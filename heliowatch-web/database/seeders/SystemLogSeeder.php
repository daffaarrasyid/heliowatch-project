<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SystemLog;

class SystemLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel dulu biar nggak numpuk data lama
        DB::table('system_logs')->truncate();

        $logs = [];

        // Generate data kemarin
        for ($i = 0; $i < 108; $i++) {
            $logs[] = $this->generateLogData(Carbon::yesterday());
        }

        // Generate data hari ini
        for ($i = 0; $i < 128; $i++) {
            $logs[] = $this->generateLogData(Carbon::today());
        }

        // Insert ke database
        foreach (array_chunk($logs, 100) as $chunk) {
            DB::table('system_logs')->insert($chunk);
        }

        $this->command->info('Mantap! 236 data log berhasil disuntikkan ke database! 🚀');
    }

    /**
     * Fungsi Helper untuk merandom data log mikrogrid
     */
    private function generateLogData(Carbon $baseDate): array
    {
        $types = [
            'Info' => ['System Recovered', 'High Irradiance', 'Scenario Start', 'Operator Login', 'Firmware Updated'],
            'Warning' => ['PV Output Drop', 'Battery SOC Low', 'High Temperature', 'Grid Frequency Sync Issue'],
            'Critical' => ['High Ramp Risk Detected', 'Battery Reserve Low', 'Inverter Fault', 'Comms Failure'],
            'Action' => ['Operator Action', 'System Auto-Correction']
        ];
        
        $scenarioList = ['Normal Operation', 'Sudden Cloud Cover', 'Community Load Spike', 'Late-Afternoon Critical'];
        $actionList = ['Load Shedding', 'Reserve Dispatch', 'Auto Recovery', 'Generator Dispatched', 'None', 'System Logged'];

        // Acak waktu (jam & menit) pada tanggal yang ditentukan
        $time = $baseDate->copy()->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
        
        // Acak Severity dan Type
        $severity = array_keys($types)[rand(0, 3)];
        $typeList = $types[$severity];
        
        // Logika Action Type menyesuaikan Severity
        $actType = $actionList[rand(0, count($actionList)-1)];
        if ($severity == 'Info') $actType = 'System Logged';
        if ($severity == 'Action') $actType = array_slice($actionList, 0, 4)[rand(0,3)];

        // Merangkai kalimat action_detail
        $actionDetail = ($actType == 'None' || $actType == 'System Logged') 
            ? $actType 
            : $actType . ' (' . rand(2, 15) . '.' . rand(0, 9) . ' kW)';

        return [
            'log_time'    => $time->format('Y-m-d H:i:s'),
            'time'        => $time->format('H:i:s'),
            'type'        => $typeList[rand(0, count($typeList)-1)],
            'severity'    => $severity,
            'condition'   => 'Metric Update (' . rand(10, 99) . ')',
            'action_type' => $actType,
            'action'      => $actionDetail,
            'scenario'    => $scenarioList[rand(0, 3)],
            'status'      => rand(0, 10) > 2 ? 'Completed' : 'Logged',
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}