# HelioWatch: Sistem Peramalan Hibrida dan Pendukung Keputusan Interpretatif untuk Mitigasi Ketidakpastian dan Peningkatan Keandalan Operasional Microgrid PV-Baterai Terisolasi pada Variabilitas Daya Jangka Pendek

HelioWatch adalah sistem cerdas berbasis *Artificial Intelligence* (AI) dan arsitektur *Single Source of Truth* (SSOT) yang melakukan *monitoring*, *forecasting*, dan deteksi anomali (seperti *Ramp Risk* dan *Battery Drop*) secara *real-time* guna menerjemahkan ketidakpastian daya pada PLTS *microgrid* terpencil menjadi prediksi risiko dan rekomendasi operasional terukur agar listrik tetap andal sebelum gangguan benar-benar terjadi.

### Tech Stack & Arsitektur

Repositori ini memuat dua layanan utama:

1. **`heliowatch-web` (Manajemen Data & UI):** Dibangun menggunakan ekosistem *framework* **Laravel 13**, dengan antarmuka yang menggunakan kombinasi **Laravel Blade, Tailwind CSS**, dan **Alpine.js**. Manajemen *database* ditangani oleh **MySQL**.

2. **`heliowatch-ai` (AI Engine & API):** Otak cerdas yang menggunakan bahasa pemrograman **Python** dan *framework* **FastAPI** untuk jalur REST API. Model *machine learning* ditenagai oleh algoritma **XGBoost** yang dilatih menggunakan *dataset dummy/sintetis* untuk mengolah data deret waktu (*time-series*) dengan akurasi tinggi.

---

## 💻 Persyaratan Sistem (Prerequisites)

Pastikan sistem operasi Anda (Windows/Mac/Linux) sudah memenuhi persyaratan berikut:

- **PHP** (Versi 8.2 atau terbaru) & **Composer**
- **Node.js** & **NPM**
- **Python** (Versi 3.8 atau terbaru) & **Pip**
- **MySQL Server** (Disarankan menggunakan XAMPP, Laragon, atau layanan sejenis)
- **Git**

---

## 🚀 Panduan Instalasi Lokal

### Langkah 1: Kloning Repositori

Buka terminal/Command Prompt dan jalankan perintah berikut untuk mengunduh *source code*:

```bash
git clone https://github.com/daffaarrasyid/heliowatch-project.git
cd heliowatch-project
```

---

### Langkah 2: Setup Database (MySQL)

1. Buka aplikasi Control Panel XAMPP/Laragon Anda dan Start module MySQL.

2. Buka Database Manager (phpMyAdmin / DBeaver / HeidiSQL).

3. Buat database baru (kosong) dengan nama:

```text
db_heliowatch
```

---

### Langkah 3: Setup Web App (Laravel)

Buka terminal baru, masuk ke folder web, dan jalankan urutan instalasi berikut:

```bash
cd heliowatch-web

# 1. Install dependensi Backend (PHP) dan Frontend (Node.js)
composer install
npm install

# 2. Setup file konfigurasi Environment
cp .env.example .env

# 3. Compile aset UI (Tailwind CSS & JavaScript) agar tampilan web interaktif
npm run build

# 4. Generate Application Key
php artisan key:generate
```

PENTING: Sebelum lanjut ke langkah 5, buka file `.env` di folder `heliowatch-web`. Pastikan kredensial database Anda sudah sesuai dengan pengaturan lokal Anda (umumnya `DB_USERNAME=root` dan `DB_PASSWORD=` dikosongkan).

```bash
# 5. Eksekusi Migrasi Tabel Database & Seeder (Untuk mengisi data awal KPI & Settings)
php artisan migrate:fresh --seed
```

---

### Langkah 4: Setup AI Engine (Python)

Buka terminal baru, masuk ke folder AI, dan jalankan instalasi environment:

```bash
cd heliowatch-ai

# 1. Buat Virtual Environment (Sangat disarankan agar modul tidak bentrok)
python -m venv venv

# 2. Aktifkan Virtual Environment
# (Untuk Pengguna Windows):
venv\Scripts\activate

# (Untuk Pengguna Mac/Linux):
source venv/bin/activate

# 3. Install Library AI (FastAPI, XGBoost, Pandas, dll)
pip install -r requirements.txt
```

---

## Cara Menjalankan Sistem (Running Locally)

Sistem HelioWatch membutuhkan 3 Terminal / Command Prompt yang berjalan secara bersamaan agar seluruh arsitektur (Web, AI, dan Robot Otomatisasi) saling terhubung.

---

### Terminal 1: Menyalakan AI Engine (Python)

Buka terminal, pastikan virtual environment masih aktif (`(venv)` muncul di terminal), arahkan ke folder `heliowatch-ai`, lalu jalankan:

```bash
uvicorn app:app --reload --port 8000
```

API Python akan berjalan dan standby di:

```text
http://127.0.0.1:8000
```

---

### Terminal 2: Menyalakan Web Server (Laravel)

Buka terminal baru, arahkan ke folder `heliowatch-web`, lalu jalankan server pada port 8080 (agar tidak bentrok dengan Python):

```bash
php artisan serve --port=8080
```

Dashboard HelioWatch sekarang dapat diakses melalui browser di:

```text
http://127.0.0.1:8080
```

---

### Terminal 3: Menyalakan Robot Otomatisasi (Cron Job)

Ini adalah fitur otomatisasi pintar HelioWatch. Buka terminal baru, arahkan ke folder `heliowatch-web`, lalu jalankan:

```bash
php artisan schedule:work
```

Biarkan terminal ini terus terbuka di latar belakang (background). Sistem akan otomatis memantau anomali (Ramp Risk / SoC Drop) setiap menit dan menyimpannya ke tabel System Log.

---

## Alur Penggunaan & Navigasi Sistem (Usage Guide)

Untuk memahami fungsionalitas dan aliran data (data flow) pada arsitektur HelioWatch, silakan telusuri menu aplikasi dengan urutan navigasi berikut:

### 1. Menu Dashboard (Pemantauan Real-Time)

- Berfungsi sebagai pusat pemantauan utama untuk melihat visualisasi metrik KPI dan grafik Power Forecast secara langsung dari Python AI Engine.

- Memiliki indikator Active Status & Recommendation yang memantau kondisi sistem secara real-time.

- Status akan otomatis berubah memberikan peringatan visual dan rekomendasi tindakan secara instan jika terdeteksi anomali.

---

### 2. Menu Alerts & Actions (Manajemen Insiden)

- Berfungsi sebagai papan tugas (To-Do List) operasional bagi teknisi atau operator lapangan.

- Menerima peringatan bahaya dari sistem deteksi latar belakang (Cron Job) yang masuk dengan status Unresolved.

- Terdapat interaksi tombol "Resolve" atau "Mark as Done" untuk menyelesaikan peringatan dan meneruskan pembaruan statusnya ke dalam catatan induk.

---

### 3. Menu Simulation (Pengujian Skenario)

- Merupakan area sandbox khusus untuk mendemonstrasikan ketangguhan algoritma sistem tanpa harus menunggu data riil anjlok.

- Memungkinkan pengguna memaksa sistem menyimulasikan kondisi ekstrem buatan (seperti Badai Tropis atau Pemadaman Jaringan).

- Memperlihatkan secara langsung bagaimana algoritma AI merespons dan memitigasi risiko terburuk.

---

### 4. Menu System Log (Rekam Jejak & Audit)

- Berfungsi sebagai Single Source of Truth (SSOT) dari keseluruhan operasional.

- Merekam secara permanen insiden yang telah diselesaikan (Resolved) oleh operator dengan status Completed.

- Menyediakan fitur filter data berdasarkan tingkat keparahan/waktu, serta opsi Export CSV untuk kebutuhan unduh laporan dan audit compliance.

---

### 5. Menu Settings (Konfigurasi Sistem)

- Berfungsi sebagai pusat kendali untuk mengatur parameter operasional Microgrid (seperti Ramp Risk Threshold, peringatan Battery SoC, dan PIN Koordinat Peta).

- Memiliki efek domino pada keseluruhan sistem untuk menentukan kapan Dashboard berubah merah, kapan peringatan masuk ke Alerts, dan kapan log dicatat secara otomatis.

- Selain dapat mengatur konfigurasi operasional, di sini juga dapat mengatur tampilan sistem.