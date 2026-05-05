<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Setting;

class DashboardApiController extends Controller
{
    public function getLiveData()
    {
        // Ambil Treshold dan Setting lainnya dari database dengan Cache untuk performa
        $settings = Cache::rememberForever('global_settings', function () {
            try {
                return Setting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        // Setel patokan bahaya (Fallback jika setting kosong: Ramp = 0.70, SoC = 30%)
        $rampThreshold = (float) ($settings['ramp_risk_threshold'] ?? 0.70);
        $socWarningThreshold = (int) ($settings['soc_warning_threshold'] ?? 30);
        $currentTimezone = $settings['timezone'] ?? 'Asia/Jakarta';
        $serverTime = Carbon::now($currentTimezone)->format('h:i A');

        // Simulasi data sensor mentah
        $pvOutput = rand(100, 180) / 10; // kW (10.0 - 18.0)
        $currentLoad = rand(80, 200) / 10; // kW (8.0 - 20.0)
        $batterySoc = rand(10, 100); // 10% - 100%
        $rampRisk = rand(10, 95) / 100; // 0.10 - 0.95
        $isCharging = $pvOutput > $currentLoad;
        $powerDifference = abs($pvOutput - $currentLoad);

        // Logika Alert: Ramp Risk dianggap bahaya kalau melebihi treshold, SoC dianggap bahaya kalau di bawah treshold
        $isRampAlert = $rampRisk >= $rampThreshold;
        $isSocAlert = $batterySoc <= $socWarningThreshold;

        // Bikin struktur data yang rapi untuk dikirim ke frontend
        $data = [
            'status' => 'success',
            'data' => [
                'server_time' => $serverTime,
                'reliability_score' => rand(85, 99), // Skor 85 - 99
                'ramp_risk' => number_format($rampRisk, 2),
                'battery_margin' => rand(15, 40),
                'energy_not_served' => number_format(rand(0, 50) / 100, 2), // 0.00 - 0.50
                'is_ramp_alert' => $isRampAlert,
                'is_soc_alert' => $isSocAlert,
                'sensor_snapshot' => [
                    'current_pv_output' => number_format($pvOutput, 1),
                    'current_load' => number_format($currentLoad, 1),
                    'battery_soc' => $batterySoc,
                    'charging_power' => $isCharging ? number_format($powerDifference, 1) : "0.0",
                    'discharging_power' => !$isCharging ? number_format($powerDifference, 1) : "0.0",
                ]
            ]
        ];

        // Kirim data sebagai JSON response
        return response()->json($data);
    }
}