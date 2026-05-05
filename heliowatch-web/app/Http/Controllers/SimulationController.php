<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SimulationController extends Controller
{
    public function index(Request $request)
    {
        $apiUrl = env('PYTHON_API_URL', 'http://127.0.0.1:8000');
        
        // Menangkap skenario yang diklik user (default: normal)
        $scenario = $request->input('scenario', 'normal');

        try {
            $responseKpi = Http::timeout(10)->get("{$apiUrl}/api/dashboard-kpi", ['scenario' => $scenario]);
            $responseForecast = Http::timeout(10)->get("{$apiUrl}/api/forecast", ['scenario' => $scenario]);

            $kpiData = $responseKpi->successful() ? $responseKpi->json()['data'] : null;
            $forecastData = $responseForecast->successful() ? $responseForecast->json()['data'] : null;

            // Menyesuaikan metadata untuk Notes berdasarkan skenario
            $scenarioDetails = $this->getScenarioDetails($scenario);

            return view('pages.simulation', compact('kpiData', 'forecastData', 'scenario', 'scenarioDetails'));

        } catch (\Exception $e) {
            Log::error("Simulation Error: " . $e->getMessage());
            return view('pages.simulation', [
                'kpiData' => null, 'forecastData' => null, 'scenario' => $scenario,
                'scenarioDetails' => $this->getScenarioDetails($scenario),
                'errorMessage' => 'Koneksi ke AI Simulator terputus.'
            ]);
        }
    }

    // Fungsi untuk mendapatkan detail skenario berdasarkan input
    private function getScenarioDetails($scenario) {
        $details = [
            'normal' => ['weather' => 'Clear to partly cloudy', 'demand' => 'Typical weekday', 'strategy' => 'Auto (Recommended)', 'desc' => 'Normal seasonal conditions with typical irradiance and community demand patterns. No major disturbances expected.'],
            'cloud_cover' => ['weather' => 'Heavy clouds/Rain', 'demand' => 'Slight decrease', 'strategy' => 'Reserve Preservation', 'desc' => 'Sudden heavy cloud cover drops PV generation by 80% between 10:00 and 14:00. Battery must support daytime load.'],
            'load_spike' => ['weather' => 'Clear', 'demand' => '+40% Peak Spike', 'strategy' => 'Peak Shaving', 'desc' => 'Unexpected community event causes a massive load spike during afternoon. High discharge rate expected.'],
            'critical' => ['weather' => 'Overcast', 'demand' => 'High continuous', 'strategy' => 'Critical Load Only', 'desc' => 'Worst-case combination: Low solar generation throughout the day combined with sustained high demand into the evening.']
        ];
        return $details[$scenario] ?? $details['normal'];
    }
}