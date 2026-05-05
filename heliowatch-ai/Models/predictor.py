import pickle
import pandas as pd
import math
import requests 
from datetime import datetime
import os
import re

# Path ke file model AI
MODEL_PATH = os.path.join(os.path.dirname(__file__), "xgboost_model.pkl")

try:
    with open(MODEL_PATH, "rb") as f:
        ai_model = pickle.load(f)
except FileNotFoundError:
    print(f"Oops! File {MODEL_PATH} belum ada!")
    ai_model = None

# Fungsi 1: Prediksi Daya 24 Jam dengan Skenario
def predict_24_hours(latitude=-7.19, longitude=108.03, base_temp=24.0, scenario="normal"):
    daily_predictions = {}
    
    try:
        url = f"https://api.open-meteo.com/v1/forecast?latitude={latitude}&longitude={longitude}&hourly=temperature_2m,shortwave_radiation&timezone=Asia%2FJakarta&forecast_days=1"
        response = requests.get(url, timeout=5)
        data = response.json()
        suhu_api = data['hourly']['temperature_2m']
        radiasi_api = data['hourly']['shortwave_radiation']
    except Exception as e:
        suhu_api = [base_temp] * 24
        radiasi_api = [max(0, 800 * math.sin(math.pi * (h - 5.5) / 13)) if 5 <= h <= 18 else 0 for h in range(24)]

    # Modifikasi data berdasarkan skenario simulasi dari Laravel
    for i in range(24):
        # Skenario Awan Tebal
        if scenario == "cloud_cover" and 10 <= i <= 14:
            radiasi_api[i] = radiasi_api[i] * 0.2
            
        jam_str = f"{i:02d}:00" 
        
        # Prediksi Physical (Baseline)
        physical_forecast = radiasi_api[i] * 0.015
        
        # Prediksi Corrected (Menggunakan XGBoost AI dengan 5 fitur)
        df_future = pd.DataFrame({
            'irradiance_wm2': [radiasi_api[i]], 
            'air_temp_c': [suhu_api[i]],
            'hour_decimal': [float(i)],
            'pv_delta_5min': [0.0],
            'pv_rolling_10min': [radiasi_api[i] * 0.02]
        })
        
        corrected_forecast = 0.0
        if ai_model is not None:
            corrected_forecast = ai_model.predict(df_future)[0]
        
        if corrected_forecast < 5 and radiasi_api[i] == 0:
            corrected_forecast = 0.0
            
        daily_predictions[jam_str] = {
            "physical": round(physical_forecast, 2),
            "corrected": round(corrected_forecast, 2)
        }
        
    return daily_predictions

# Fungsi 2: Kalkulasi KPI dengan Threshold Dinamis
def calculate_dashboard_kpi(current_power, next_hour_power, battery_soc, current_load, ramp_threshold=0.70, soc_warning=30.0):
    power_drop = current_power - next_hour_power
    ramp_risk = min(1.0, power_drop / 400.0) if power_drop > 0 else 0.02 
        
    reliability_score = 100 - (ramp_risk * 30) - ((100 - battery_soc) * 0.15)
    reliability_score = max(0, min(100, round(reliability_score))) 
    
    if reliability_score >= 80:
        status_rel = "Good"
    elif reliability_score >= 60:
        status_rel = "Moderate"
    else:
        status_rel = "Poor"

    available_battery_power = (battery_soc / 100) * 2000 
    total_available_power = next_hour_power + available_battery_power
    deficit = current_load - total_available_power
    ens = round(deficit / 1000, 2) if deficit > 0 else 0.00 

    return {
        "reliability_score": reliability_score,
        "reliability_status": status_rel,
        "ramp_risk": round(ramp_risk, 2),
        "is_ramp_alert": ramp_risk > ramp_threshold,
        "battery_margin": battery_soc,
        "is_soc_alert": battery_soc < soc_warning,
        "energy_not_served": ens
    }

# Fungsi 3: Dummy Sensor dengan Skenario Beban
def get_current_sensor_data(scenario="normal"):
    jam_sekarang = datetime.now().hour
    soc, charging, discharging = (48, 2.1, 0.0) if 7 <= jam_sekarang <= 16 else (35, 0.0, 1.5)
    load = 8.9
    
    if scenario == "load_spike":
        load = 15.5
        discharging = 4.0
        
    capacity = 52.0
    usable = round((soc / 100) * capacity, 1)
    
    return {
        "battery_soc": soc,
        "battery_capacity": capacity,
        "usable_capacity": usable,
        "charging_power": charging,
        "discharging_power": discharging,
        "current_pv_output": 12.6, 
        "current_load": load        
    }

# Fungsi 4: Adapter / Parser JSON untuk UI Alerts & Actions
def get_recommendation_from_json(json_data):
    if not json_data:
        return {"status_code": "DATA ERROR"}

    ui_color = json_data.get('ui_status_color', 'gray')
    color_map = {"red": "#ff4b4b", "orange": "#ffa421", "green": "#2ecc71"}

    # Memecah string instruksi menjadi array untuk checklist UI
    instruksi_mentah = json_data.get('operator_instruction', '')
    parsed_instructions = re.split(r'\d+\)', instruksi_mentah)
    clean_instructions = [i.strip() for i in parsed_instructions if i.strip()]

    return {
        "status_code": json_data.get('risk_level', 'UNKNOWN').upper(),
        "color": color_map.get(ui_color, "#808495"),
        "active_alerts": [
            {
                "id": 1,
                "type": f"{json_data.get('risk_level', 'Alert')} Status",
                "description": json_data.get('explanation', ''),
                "severity": json_data.get('risk_level', 'Critical'),
                "time_ago": "Baru saja"
            }
        ],
        "primary_action": {
            "title": json_data.get('action_code', 'ACTION').replace("_", " "),
            "description": json_data.get('recommended_action', ''),
            "est_effect": json_data.get('operational_objective', '')
        },
        "instructions": clean_instructions,
        "affected_loads": [
            {
                "name": json_data.get('affected_load', 'Tidak ada data'),
                "power": f"{json_data.get('load_kw', 0)} kW",
                "status": "At Risk" if ui_color == 'red' else "Safe"
            }
        ],
        "technical_basis": {
            "ramp_risk": json_data.get('ramp_risk_proxy', 0),
            "battery_soc": json_data.get('battery_soc', 0),
            "est_ens": json_data.get('estimated_ens_30min_kwh', 0),
            "net_margin": json_data.get('forecast_net_margin_30min_kw', 0),
            "srs_score": json_data.get('solar_reliability_score', 0)
        },
        "community_notice": json_data.get('community_notice', ''),
        "raw_log_data": {
            "timestamp": json_data.get('timestamp'),
            "scenario": json_data.get('scenario')
        }
    }

def get_simulation_impact(scenario="normal"):
    """
    Fungsi untuk mengenerate KPI spesifik skenario dan perbandingan dampaknya
    berdasarkan XGBoost / Logic AI.
    """
    # Default (Normal)
    kpi = {"ramp_risk": 0.28, "ens": 0.0, "soc": 65, "srs": 95, "srs_exp": 95}
    impact = {
        "baseline": {"ramp_risk": 0.28, "ens": 0.0, "soc": 65},
        "optimized": {"ramp_risk": 0.20, "ens": 0.0, "soc": 70}
    }
    
    if scenario == "cloud_cover":
        kpi = {"ramp_risk": 0.85, "ens": 12.5, "soc": 25, "srs": 60, "srs_exp": 85}
        impact["baseline"] = {"ramp_risk": 0.85, "ens": 12.5, "soc": 15}
        impact["optimized"] = {"ramp_risk": 0.45, "ens": 2.1, "soc": 35}
        
    elif scenario == "load_spike":
        kpi = {"ramp_risk": 0.65, "ens": 35.2, "soc": 28, "srs": 70, "srs_exp": 88}
        impact["baseline"] = {"ramp_risk": 0.75, "ens": 35.2, "soc": 18}
        impact["optimized"] = {"ramp_risk": 0.35, "ens": 4.8, "soc": 32}
        
    elif scenario == "critical":
        kpi = {"ramp_risk": 0.92, "ens": 45.0, "soc": 10, "srs": 45, "srs_exp": 80}
        impact["baseline"] = {"ramp_risk": 0.95, "ens": 45.0, "soc": 5}
        impact["optimized"] = {"ramp_risk": 0.60, "ens": 15.0, "soc": 20}

    return {"kpi": kpi, "impact": impact}