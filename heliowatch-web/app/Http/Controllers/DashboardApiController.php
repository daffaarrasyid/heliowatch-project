<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http; // Wajib dipanggil
use Carbon\Carbon;
use App\Models\Setting;

class DashboardApiController extends Controller
{
    public function getLiveData(Request $request)
    {
        $settings = Cache::rememberForever('global_settings', function () {
            try {
                return Setting::pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        $rampThreshold = (float) ($settings['ramp_risk_threshold'] ?? 0.70);
        $socWarningThreshold = (int) ($settings['soc_warning_threshold'] ?? 30);
        $currentTimezone = $settings['timezone'] ?? 'Asia/Jakarta';
        $serverTime = Carbon::now($currentTimezone)->format('h:i A');

        //TANGKAP SKENARIO DARI JAVASCRIPT
        $scenario = $request->query('scenario', 'normal');

        try {
            $response = Http::timeout(5)->get('http://127.0.0.1:8000/api/dashboard-kpi', [
                'ramp_threshold' => $rampThreshold,
                'soc_warning' => $socWarningThreshold,
                'scenario' => $scenario 
            ]);

            if ($response->successful()) {
                $aiData = $response->json()['data'];

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'server_time' => $serverTime,
                        'reliability_score' => $aiData['reliability_score'],
                        'ramp_risk' => $aiData['ramp_risk'],
                        'battery_margin' => $aiData['battery_margin'],
                        'energy_not_served' => $aiData['energy_not_served'],
                        'is_ramp_alert' => $aiData['is_ramp_alert'],
                        'is_soc_alert' => $aiData['is_soc_alert'],
                        'sensor_snapshot' => $aiData['sensor_snapshot'],
                        // --- MENANGKAP CONFIDENCE SCORE DARI PYTHON ---
                        'ai_confidence' => $aiData['ai_confidence'] ?? 95.0,
                        'lead_time_horizon' => $aiData['lead_time_horizon'] ?? '1 Hour (t+60)'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'AI Engine Offline'], 500);
        }
    }
}
