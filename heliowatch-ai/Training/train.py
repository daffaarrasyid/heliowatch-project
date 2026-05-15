import pandas as pd
from xgboost import XGBRegressor
import pickle
import os

print("1. Membaca data FEATURES Microgrid...")
df = pd.read_excel("microgrid_features (1).xlsx")

print("2. Memilih 15 fitur unggulan (Edge-Constrained Feature Selection)...")

# Memanggil 15 fitur yang sudah ada di Excel
features = [
    'irradiance_wm2', 
    'air_temp_c', 
    'hour_decimal', 
    'pv_delta_10min',
    'irradiance_delta_10min',
    'load_delta_10min',
    'soc_delta_10min',
    'pv_rolling_10min',
    'load_rolling_10min',
    'irradiance_rolling_10min',
    'pv_clearness_index',
    'temp_factor_now',
    'cloud_drop_signal',
    'load_rise_signal',
    'low_battery_signal'
]

# Mengatasi jika ada data kosong (Missing Values) di dalam Excel sebelum di-training
df[features] = df[features].fillna(0)

# Memisahkan Fitur (X) dan Target (y)
X = df[features]
y = df['pv_output_kw']

print("3. AI sedang belajar dari 15 fitur canggih... 🧠⏳")
# Tuning parameter agar model tidak terlalu besar sizenya (cocok untuk Edge/Raspberry Pi)
ai_model = XGBRegressor(
    n_estimators=150,    # Cukup 150 pohon agar model ringan
    max_depth=5,         # Dibatasi agar tidak overfitting
    learning_rate=0.05, 
    random_state=42
)
ai_model.fit(X, y)

print("4. Menyimpan otak AI Super (xgboost_model.pkl)...")
if not os.path.exists("Models"):
    os.makedirs("Models")
    
with open("Models/xgboost_model.pkl", "wb") as f:
    pickle.dump(ai_model, f)
    
print("\n🎉 BERHASIL! AI sekarang sudah jalan pakai 15 Fitur Domain-Informed & Temporal!")