<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Models\SystemLog;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SystemMonitor extends Command
{
    protected $signature = 'system:monitor';

    protected $description = 'Patroli background untuk mengecek sensor dan mencatat anomali ke System Log';

    public function handle()
    {
        // Baca aturan batas bahaya dari Settings
        $settings = Cache::rememberForever('global_settings', function () {
            try {
                return Setting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        $socThreshold = (int) ($settings['soc_warning_threshold'] ?? 30);
        $rampThreshold = (float) ($settings['ramp_risk_threshold'] ?? 0.70);

        // Simulasi baca sensor IoT
        // Karena kita masih simulasi, kita bikin robot ini nge-random angka kayak di Dashboard
        $currentSoc = rand(10, 100);
        $currentRamp = rand(10, 95) / 100;

        // Evaluasi dan eksekusi Log jika ada anomali
        $anomaliesDetected = 0;

        // Simpan waktu sekarang 
        $now = Carbon::now($settings['timezone'] ?? 'Asia/Jakarta');

        // Cek Bahaya Baterai
        if ($currentSoc <= $socThreshold) {
            SystemLog::create([
                'severity' => 'Warning',
                'type' => 'Battery Storage',
                'condition' => "Auto-Detect: Battery SoC dropped to {$currentSoc}%",
                'log_time' => $now,
                'time' => $now->format('H:i:s'),
                'action_type' => 'System Alert', 
                'action' => 'Pending Operator Review', 
                'status' => 'Unresolved',
                'scenario' => 'Real-Time IoT'
            ]);
            $anomaliesDetected++;
            $this->error("Bahaya! Baterai Drop: {$currentSoc}%");
        }

        // Cek Bahaya Ramp Risk
        if ($currentRamp >= $rampThreshold) {
            SystemLog::create([
                'severity' => 'Critical',
                'type' => 'Grid Stability',
                'condition' => "Auto-Detect: High Ramp Risk at {$currentRamp}",
                'log_time' => $now,
                'time' => $now->format('H:i:s'),
                'action_type' => 'System Alert',
                'action' => 'Pending Operator Review', 
                'status' => 'Unresolved',
                'scenario' => 'Real-Time IoT'
            ]);
            $anomaliesDetected++;
            $this->error("Kritis! Ramp Risk Tinggi: {$currentRamp}");
        }

        // Laporan Akhir Patroli
        if ($anomaliesDetected == 0) {
            $this->info("Patroli aman. SoC: {$currentSoc}%, Ramp: {$currentRamp}. Tidak ada log dicatat.");
        } else {
            $this->info("Patroli selesai. Mencatat {$anomaliesDetected} peringatan ke database.");
        }
    }
}
