# import paho.mqtt.client as mqtt
# import json
# import time

# # KONFIGURASI MQTT BROKER (EDGE RASPBERRY PI)
# MQTT_BROKER = "127.0.0.1"  # Nanti diganti IP Raspberry Pi di lapangan
# MQTT_PORT = 1883           # Port standar MQTT
# MQTT_TOPIC = "heliowatch/sensors/live"

# # Fungsi saat berhasil nyambung ke Broker (Raspberry Pi)
# def on_connect(client, userdata, flags, rc):
#     if rc == 0:
#         print(f"✅ [MQTT] Berhasil terhubung ke Edge Broker (Raspberry Pi)")
#         print(f"📡 [MQTT] Mendengarkan topik: {MQTT_TOPIC} via LAN...")
#         client.subscribe(MQTT_TOPIC)
#     else:
#         print(f"❌ [MQTT] Gagal terhubung, kode error: {rc}")

# # Fungsi saat sensor ngirim data (Masuk lewat LAN)
# def on_message(client, userdata, msg):
#     try:
#         # 1. Terima data mentah dari sensor IoT
#         raw_payload = msg.payload.decode('utf-8')
#         sensor_data = json.loads(raw_payload)
        
#         print(f"📥 [DATA MASUK] {time.strftime('%H:%M:%S')} | Beban: {sensor_data['load']} kW | SOC: {sensor_data['soc']}%")
        
#         # 2. DI SINI DATA MASUK KE FUNGSI AI KITA
#         # predictor.clean_sensor_data(...) 
#         # predictor.extract_15_optimized_features(...)
#         # ai_model.predict(...)
        
#         print("🤖 [AI ENGINE] Data sedang diproses secara Asynchronous (Tanpa memblokir UI Web)...")
        
#     except Exception as e:
#         print(f"⚠️ [MQTT ERROR] Data korup atau format salah: {e}")


# # INISIALISASI & JALANKAN MQTT CLIENT
# if __name__ == "__main__":
#     print("🚀 Memulai Sistem MQTT Subscriber untuk HelioWatch...")
    
#     # Inisialisasi klien
#     client = mqtt.Client(client_id="Heliowatch_AI_Core")
#     client.on_connect = on_connect
#     client.on_message = on_message
    
#     try:
#         # Koneksi ke broker
#         client.connect(MQTT_BROKER, MQTT_PORT, 60)
#         # Looping abadi mendengarkan sensor (Non-blocking)
#         client.loop_forever()
#     except ConnectionRefusedError:
#         print("❌ [FATAL] Broker Mosquitto belum menyala di Raspberry Pi.")
#         print("💡 Tips: Jalankan 'sudo systemctl start mosquitto' di terminal Edge.")