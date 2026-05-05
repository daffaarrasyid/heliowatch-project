<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SettingController extends Controller
{
    // Menampilkan halaman pengaturan
    public function index()
    {
        try {
            // Ambil dari Cache
            $settings = Cache::rememberForever('global_settings', function () {
                return Setting::pluck('value', 'key')->toArray();
            });


            $timezones = [
                'Asia/Jakarta' => 'WIB (UTC+7) - Asia/Jakarta',
                'Asia/Makassar' => 'WITA (UTC+8) - Asia/Makassar',
                'Asia/Jayapura' => 'WIT (UTC+9) - Asia/Jayapura',
            ];

            return view('pages.settings', compact('settings', 'timezones'));

        } catch (\Exception $e) {
            Log::error("Settings Error: " . $e->getMessage());
            return view('pages.settings', [
                'settings' => [],
                'timezones' => ['Asia/Jakarta' => 'WIB (UTC+7) - Asia/Jakarta'],
                'errorMessage' => 'Gagal memuat pengaturan sistem.',
            ]);
        }
    }

    public function update(Request $request)
    {
        Log::info('SettingController update method called', ['request_data' => $request->all()]);

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_latitude' => 'required|numeric',  
            'site_longitude' => 'required|numeric',
            'operator_name' => 'required|string|max:255',
            'timezone' => 'required|string|max:255',
            'ramp_risk_threshold' => 'required|numeric', 
            'soc_warning_threshold' => 'required|numeric',
            'ens_threshold' => 'required|numeric',
            'refresh_interval' => 'required|in:15,30,60',
            'theme' => 'required|in:light,dark,system',
            'email_notifications' => 'required|in:0,1',
            'sms_notifications' => 'required|in:0,1',
            'alert_sounds' => 'required|in:0,1',
            'load_priority_critical' => 'required|in:1,2,3',
            'load_priority_flexible' => 'required|in:1,2,3',
            'load_priority_nonessential' => 'required|in:1,2,3',
        ]);

        try {
            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Update timestamp terakhir tersinkronisasi
            Setting::updateOrCreate(
                ['key' => 'settings_last_synced'],
                ['value' => Carbon::now($validated['timezone'])->translatedFormat('d M Y • H:i')]
            );

            // Hapus cache agar Provider memuat ulang data baru ke seluruh web
            Cache::forget('global_settings');

            return redirect()->back()->with('success', 'Configuration synced successfully!');

        } catch (\Exception $e) {
            Log::error("Settings Update Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan konfigurasi.');
        }
    }

    public function reset(Request $request)
    {
        Log::info('SettingController reset method called');

        try {
            $defaults = [
                'site_name' => 'Fasilitas Riset IPB',
                'site_latitude' => '-6.5569',
                'site_longitude' => '106.7238',
                'operator_name' => 'HelioWatch Operations Team',
                'timezone' => 'Asia/Jakarta', 
                'ramp_risk_threshold' => '0.70',
                'soc_warning_threshold' => '30',
                'ens_threshold' => '2.00',
                'refresh_interval' => '30',
                'theme' => 'light',
                'email_notifications' => '1',
                'sms_notifications' => '1',
                'alert_sounds' => '1',
                'load_priority_critical' => '1',
                'load_priority_flexible' => '2',
                'load_priority_nonessential' => '3',
                'contact_email' => 'operator@heliowatch.com',
                'system_status' => 'Operational',
                'settings_last_synced' => Carbon::now('Asia/Jakarta')->translatedFormat('d M Y • H:i'),
            ];

            foreach ($defaults as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Hapus cache saat reset ke default
            Cache::forget('global_settings');

            return redirect()->back()->with('success', 'Settings reverted to factory defaults.');

        } catch (\Exception $e) {
            Log::error("Settings Reset Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengatur ulang konfigurasi.');
        }
    }
}