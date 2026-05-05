<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Tangkap input filter dari request
            $filterSeverity = $request->input('severity', 'All');
            $filterScenario = $request->input('scenario', 'All Scenarios');
            $filterAction = $request->input('action_type', 'All Actions');
            $filterDate = $request->input('date_range', 'Today'); // Filter Tanggal Baru
            $timezone = 'Asia/Jakarta';

            // Cek apakah tombol Export ditekan
            $isExport = $request->has('export');

            $scenarios = SystemLog::select('scenario')->distinct()->pluck('scenario')->toArray();
            $actionTypes = SystemLog::select('action_type')->distinct()->pluck('action_type')->toArray();

            $query = SystemLog::query();

            if ($filterSeverity !== 'All') {
                $query->where('severity', $filterSeverity);
            }
            if ($filterScenario !== 'All Scenarios') {
                $query->where('scenario', $filterScenario);
            }
            if ($filterAction !== 'All Actions') {
                $query->where('action_type', $filterAction);
            }
            
            // Logika Filter Tanggal
            if ($filterDate === 'Today') {
                $query->whereDate('log_time', Carbon::today($timezone));
            } elseif ($filterDate === 'Yesterday') {
                $query->whereDate('log_time', Carbon::yesterday($timezone));
            } elseif ($filterDate === 'Last 7 Days') {
                $query->whereDate('log_time', '>=', Carbon::today($timezone)->subDays(7));
            }

            // Fitur Export CS
            if ($isExport) {
                // Ambil semua data sesuai filter, abaikan pagination
                $exportData = $query->orderBy('log_time', 'desc')->get();
                return $this->exportCsv($exportData);
            }

            // Eksekusi Pagination
            $logs = $query->orderBy('log_time', 'desc')->paginate(8)->withQueryString();

            // Kalkulasi KPI untuk ditampilkan di atas tabel
            $today = Carbon::today($timezone);
            $yesterday = Carbon::yesterday($timezone);
            $sevenDaysAgo = Carbon::today($timezone)->subDays(6);

            $timelineTitle = 'All Time';
            if ($filterDate === 'Today') {
                $timelineTitle = Carbon::today($timezone)->translatedFormat('d M Y');
            } elseif ($filterDate === 'Yesterday') {
                $timelineTitle = Carbon::yesterday($timezone)->translatedFormat('d M Y');
            } elseif ($filterDate === 'Last 7 Days') {
                $timelineTitle = $sevenDaysAgo->translatedFormat('d M Y') . ' – ' . Carbon::today($timezone)->translatedFormat('d M Y');
            }

            $kpi = [
                'total_events' => $this->getKpiData('total', $today),
                'total_trend' => $this->calculateTrend('total', $today, $yesterday),
                'critical_alerts' => $this->getKpiData('critical', $today),
                'critical_trend' => $this->calculateTrend('critical', $today, $yesterday),
                'actions_executed' => $this->getKpiData('action', $today),
                'actions_trend' => $this->calculateTrend('action', $today, $yesterday),
                'availability' => '99.62%', 'availability_trend' => '+0.18%'
            ];

            // Dat Chart
            $chartData = $this->generateChartData($filterDate);

            // Latest Critical Alert
            $latestCriticalRaw = SystemLog::where('severity', 'Critical')->orderBy('log_time', 'desc')->first();
            
            $latestCritical = $latestCriticalRaw ? [
                'title' => $latestCriticalRaw->type ?? 'Critical Alert',
                'time' => Carbon::parse($latestCriticalRaw->log_time)->setTimezone($timezone)->translatedFormat('d M Y • H:i:s') . ' WIB',
                // Ambil deskripsi dari kolom 'condition' yang ada di database
                'desc' => $latestCriticalRaw->condition ?? 'Terjadi anomali kritis pada sistem.',
                // Catatan: Jika ramp_risk/threshold tidak ada di kolom DB, mending dihapus dari UI 
                // atau pakai regex untuk ngekstrak angkanya dari string 'condition'
            ] : null;

            return view('pages.system_log', compact(
                'kpi', 'logs', 'latestCritical', 'chartData', 
                'filterSeverity', 'filterScenario', 'filterAction', 'filterDate', 'timelineTitle',
                'scenarios', 'actionTypes'
            ));

        } catch (\Exception $e) {
            Log::error("SystemLog Error: " . $e->getMessage());
            return view('pages.system_log', ['errorMessage' => 'Gagal mengambil riwayat sistem.']);
        }
    }

    // Fungsi untuk mengekspor data log ke format CSV
    private function exportCsv($logs)
    {
        $fileName = 'HelioWatch_SystemLogs_' . date('Y-m-d_H-i') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($logs) {
            $file = fopen('php://output', 'w');
            // Header Kolom Excel
            fputcsv($file, ['Log Time', 'Time', 'Event Type', 'Severity', 'System Condition', 'Action Type', 'Action Detail', 'Scenario', 'Status']);

            // Isi Data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->log_time, $log->time, $log->type, $log->severity, 
                    $log->condition, $log->action_type, $log->action, $log->scenario, $log->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Fungsi untuk menghitung KPI berdasarkan jenis dan tanggal
    private function getKpiData($type, $date) {
        $query = SystemLog::whereDate('log_time', $date);
        if ($type === 'critical') $query->where('severity', 'Critical');
        if ($type === 'action') $query->where('severity', 'Action');
        return $query->count();
    }

    private function calculateTrend($type, $today, $yesterday) {
        $countToday = $this->getKpiData($type, $today);
        $countYesterday = $this->getKpiData($type, $yesterday);
        if ($countYesterday == 0) return $countToday > 0 ? '+100%' : '0%';
        $diff = $countToday - $countYesterday;
        $percentage = ($diff / $countYesterday) * 100;
        return ($diff > 0 ? '+' : '') . round($percentage, 1) . '%';
    }

    private function generateChartData($filterDate) {
        $buckets = array_fill(0, 48, ['Info' => 0, 'Warning' => 0, 'Critical' => 0, 'Action' => 0]);
        
        $query = SystemLog::query();
        if ($filterDate === 'Today') $query->whereDate('log_time', Carbon::today());
        elseif ($filterDate === 'Yesterday') $query->whereDate('log_time', Carbon::yesterday());
        if ($filterDate === 'Last 7 Days') {
            $query->whereDate('log_time', '>=', Carbon::today()->subDays(7));
        }
        $logs = $query->get();
        foreach ($logs as $log) {
            $time = Carbon::parse($log->log_time)->setTimezone('Asia/Jakarta');
            $index = ($time->hour * 2) + ($time->minute >= 30 ? 1 : 0);
            if(isset($buckets[$index][$log->severity])) {
                $buckets[$index][$log->severity]++;
            }
        }
        return [
            'info' => array_column($buckets, 'Info'), 'warning' => array_column($buckets, 'Warning'),
            'critical' => array_column($buckets, 'Critical'), 'action' => array_column($buckets, 'Action'),
        ];
    }
}