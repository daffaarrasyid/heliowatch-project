<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\SystemLog;

class DashboardController extends Controller
{
    public function index()
    {
        $apiUrl = env('PYTHON_API_URL', 'http://127.0.0.1:8000');

        try {
            // Ambil setting dari database
            $rampThreshold = Setting::where('key', 'ramp_risk_threshold')->value('value') ?? 0.70;
            $socWarning = Setting::where('key', 'soc_warning_threshold')->value('value') ?? 30.0;

            // Ambil API KPI dan Forecast dari Python Engine
            $responseKpi = Http::timeout(10)->get("{$apiUrl}/api/dashboard-kpi", [
                'ramp_threshold' => $rampThreshold,
                'soc_warning' => $socWarning
            ]);
            $responseForecast = Http::timeout(10)->get("{$apiUrl}/api/forecast");

            $kpiData = $responseKpi->successful() ? $responseKpi->json()['data'] : null;
            $forecastData = $responseForecast->successful() ? $responseForecast->json()['data'] : null;

            $activeStatus = SystemLog::where('status', 'Unresolved')
                                     ->orderBy('log_time', 'desc')
                                     ->first(); // Cuma ambil 1 yang paling gawat/baru

            return view('pages.dashboard', [
                'kpiData' => $kpiData,
                'forecastData' => $forecastData,
                'activeStatus' => $activeStatus, // <--- Lempar ke Blade Dashboard
                'errorMessage' => null
            ]);

        } catch (\Exception $e) {
            Log::error("Dashboard Error: " . $e->getMessage());
            return view('pages.dashboard', [
                'kpiData' => null, 'forecastData' => null, 'activeStatus' => null,
                'errorMessage' => 'Koneksi ke sistem terputus.'
            ]);
        }
    }

    // Metode baru untuk endpoint API yang dipanggil oleh JS di Dashboard untuk data live (5 detik sekali)
    public function liveData(Request $request)
    {
        $apiUrl = env('PYTHON_API_URL', 'http://127.0.0.1:8000');
        $scenario = $request->input('scenario', 'normal');

        try {
            $responseKpi = Http::timeout(3)->get("{$apiUrl}/api/dashboard-kpi", ['scenario' => $scenario]);
            
            if ($responseKpi->successful()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $responseKpi->json()['data']
                ]);
            }
            return response()->json(['status' => 'error']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'AI Offline']);
        }
    }
}