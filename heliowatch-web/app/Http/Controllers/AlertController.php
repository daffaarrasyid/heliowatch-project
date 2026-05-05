<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    public function index()
    {
        $apiUrl = env('PYTHON_API_URL', 'http://127.0.0.1:8000');

        try {
            $responseAlerts = Http::timeout(10)->get("{$apiUrl}/api/alerts");
            $alertsData = $responseAlerts->successful() ? $responseAlerts->json()['data'] : null;

            return view('pages.alerts', [
                'alertsData' => $alertsData,
                'errorMessage' => null
            ]);

        } catch (\Exception $e) {
            Log::error("Alerts Error: " . $e->getMessage());
            return view('pages.alerts', [
                'alertsData' => null,
                'errorMessage' => 'Gagal memuat rekomendasi tindakan dari Engine.'
            ]);
        }
    }
}