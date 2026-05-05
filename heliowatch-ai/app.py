from fastapi import FastAPI, HTTPException, Query
import json
import os
from datetime import datetime
from Models.predictor import predict_24_hours, get_current_sensor_data, calculate_dashboard_kpi, get_recommendation_from_json, get_simulation_impact

from Models.predictor import (
    predict_24_hours, 
    get_current_sensor_data, 
    calculate_dashboard_kpi,
    get_recommendation_from_json
)

app = FastAPI(
    title="HelioWatch API",
    description="Backend Service Python untuk HelioWatch AI",
    version="2.0.0"
)

JSON_DATA_PATH = os.path.join(os.path.dirname(__file__), "Data", "latest_decision.json")

@app.get("/")
def root():
    return {"message": "HelioWatch API is Active! Go to /docs"}

@app.get("/api/forecast")
def get_forecast(scenario: str = Query("normal", description="Tipe skenario simulasi")):
    try:
        forecast = predict_24_hours(scenario=scenario)
        return {"status": "success", "data": forecast}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/dashboard-kpi")
def get_dashboard_kpi(
    ramp_threshold: float = Query(0.70),
    soc_warning: float = Query(30.0),
    scenario: str = Query("normal")
):
    try:
        sensor = get_current_sensor_data(scenario=scenario)
        forecast = predict_24_hours(scenario=scenario)
        
        # [Kalkulasi KPI lama untuk Dashboard...]
        curr_pwr = forecast.get(f"{datetime.now().hour:02d}:00", {"corrected": 0})["corrected"]
        next_pwr = forecast.get(f"{(datetime.now().hour + 1) % 24:02d}:00", {"corrected": 0})["corrected"]
        
        kpi = calculate_dashboard_kpi(curr_pwr, next_pwr, sensor['battery_soc'], sensor['current_load'], ramp_threshold, soc_warning)
        kpi["sensor_snapshot"] = sensor
        
        # ---> TAMBAHAN BARU UNTUK HALAMAN SIMULASI <---
        kpi["simulation_data"] = get_simulation_impact(scenario)
        
        return {"status": "success", "data": kpi}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/api/alerts")
def get_alerts():
    try:
        with open(JSON_DATA_PATH, "r") as f:
            decision_data = json.load(f)
        return {"status": "success", "data": decision_data} # Langsung lempar!
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run("app:app", host="0.0.0.0", port=8000, reload=True)