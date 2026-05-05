<!DOCTYPE html>
<html lang="en" class="{{ isset($appTheme) && $appTheme === 'dark' ? 'dark' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelioWatch - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: 0,
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: 1,
                                transform: 'translateY(0)'
                            }
                        },
                        fadeInDown: {
                            '0%': {
                                opacity: 0,
                                transform: 'translateY(-20px)'
                            },
                            '100%': {
                                opacity: 1,
                                transform: 'translateY(0)'
                            }
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                        'fade-in-down': 'fadeInDown 0.5s ease-out forwards'
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>
</head>

<body data-theme="{{ $appTheme ?? 'light' }}"
    class="{{ isset($appTheme) && $appTheme === 'dark' ? 'bg-slate-950 text-slate-100' : 'bg-[#fcfcfc] text-gray-800' }} font-sans antialiased flex h-screen overflow-hidden transition-colors duration-300">

    <!-- Global Alert Toast -->
    <div id="global-alert-toast"
        class="fixed top-6 right-6 z-[9999] transform transition-all duration-500 translate-x-[150%] opacity-0">
        <div
            class="bg-white dark:bg-slate-800 border-l-4 border-red-500 shadow-2xl dark:shadow-rose-900/20 rounded-xl p-4 flex items-start gap-4 max-w-sm w-80">
            <div class="text-red-500 mt-0.5 animate-pulse">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div class="flex-1">
                <h4 id="toast-title" class="text-sm font-bold text-gray-900 dark:text-slate-100">Critical Alert</h4>
                <p id="toast-message" class="text-xs text-gray-600 dark:text-slate-400 mt-1 leading-tight">Anomaly
                    detected in the system.</p>
                <div class="mt-3 flex items-center gap-3">
                    <a href="{{ route('alerts') ?? '#' }}"
                        class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm transition-colors">Take
                        Action</a>
                    <button onclick="closeToast()"
                        class="text-xs font-medium text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition-colors">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Sound -->
    <audio id="alert-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3"
        preload="auto"></audio>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity"
        onclick="toggleSidebar()"></div>

    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto w-full relative scroll-smooth flex flex-col">
        <!-- Top Nav Mobile Only (Hamburger Menu) -->
        <div
            class="lg:hidden bg-white px-6 py-4 flex justify-between items-center shadow-sm z-30 transition-colors duration-300 dark:bg-slate-900 dark:border-b dark:border-slate-800">
            <h1 class="text-xl font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                <span class="text-[#005DCE]">☀️</span> HelioWatch
            </h1>
            <button onclick="toggleSidebar()"
                class="text-gray-500 hover:text-[#005DCE] dark:text-slate-400 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <div class="p-4 md:p-8 lg:p-10 w-full mx-auto max-w-[1600px]">
            @yield('content')
        </div>
    </main>

    <script>
        function closeToast() {
            const toast = document.getElementById('global-alert-toast');
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-[150%]', 'opacity-0');
        }

        function showToast(title, message) {
            document.getElementById('toast-title').innerText = title;
            document.getElementById('toast-message').innerText = message;
            
            const toast = document.getElementById('global-alert-toast');
            toast.classList.remove('translate-x-[150%]', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function applyThemePreference() {
            const themeMode = document.body.dataset.theme || 'light';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = themeMode === 'dark' || (themeMode === 'system' && prefersDark);

            if (isDark) {
                document.documentElement.classList.add('dark');
                document.body.classList.remove('bg-[#fcfcfc]', 'text-gray-800');
                document.body.classList.add('bg-slate-950', 'text-slate-100');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('bg-slate-950', 'text-slate-100');
                document.body.classList.add('bg-[#fcfcfc]', 'text-gray-800');
            }
        }

        applyThemePreference();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyThemePreference);

        document.addEventListener("DOMContentLoaded", function() {
            // Real-time clock update
            const appTimezone = "{{ $globalSettings['timezone'] ?? 'Asia/Jakarta' }}";
            setInterval(function() {
                const timeElements = document.querySelectorAll('#current-time');
                if (timeElements.length > 0) {
                    const now = new Date();
                    const options = {timeZone: appTimezone, day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false};
                    let timeString = now.toLocaleDateString('en-GB', options).replace(',', ' •');
                    timeElements.forEach(el => el.innerText = timeString + ' WIB');
                }
            }, 1000);

            // AJAX polling for live data
            const isSoundEnabled = {{ isset($globalSettings['alert_sounds']) && $globalSettings['alert_sounds'] == '1' ? 'true' : 'false' }};
            let alertAlreadyTriggered = false;
            setInterval(async function() {
                try {
                    const response = await fetch("{{ route('api.live') ?? '/live-data' }}", { cache: 'no-store' });
                    const result = await response.json();
                    if(result.status === 'success') {
                        const kpi = result.data;
                        const sensor = kpi.sensor_snapshot;
                        
                        // Check alerts
                        if (kpi.is_ramp_alert || kpi.is_soc_alert) {
                            if (!alertAlreadyTriggered) {
                                let alertMsg = kpi.is_ramp_alert ? 'High Ramp Risk detected. Grid instability possible.' : 'Battery SoC has dropped below the warning threshold.';
                                showToast('System Warning', alertMsg);
                                if (isSoundEnabled) document.getElementById('alert-sound').play().catch(e => {});
                                alertAlreadyTriggered = true;
                            }
                        } else {
                            alertAlreadyTriggered = false;
                            closeToast();
                        }
                        
                        // Update dashboard values
                        const updateText = (id, val) => { if(document.getElementById(id)) document.getElementById(id).innerText = val; };
                        updateText('val-srs', kpi.reliability_score);
                        updateText('val-ramp', kpi.ramp_risk);
                        updateText('val-bat-margin', kpi.battery_margin);
                        updateText('val-ens', kpi.energy_not_served);
                        updateText('val-pv-out', sensor.current_pv_output);
                        updateText('val-load', sensor.current_load);
                        updateText('val-snap-soc', sensor.battery_soc);
                        updateText('val-circle-soc', sensor.battery_soc);
                        updateText('val-charge', sensor.charging_power);
                        updateText('val-discharge', sensor.discharging_power);
                        
                        // Update alert indicators
                        if(document.getElementById('alert-indicator')) document.getElementById('alert-indicator').classList.toggle('hidden', !kpi.is_ramp_alert && !kpi.is_soc_alert);
                        if(document.getElementById('alert-ramp')) document.getElementById('alert-ramp').style.display = kpi.is_ramp_alert ? 'flex' : 'none';
                        if(document.getElementById('alert-soc')) document.getElementById('alert-soc').style.display = kpi.is_soc_alert ? 'flex' : 'none';
                        if(document.getElementById('alert-normal')) document.getElementById('alert-normal').style.display = (!kpi.is_ramp_alert && !kpi.is_soc_alert) ? 'flex' : 'none';
                        
                        // Update battery circle
                        if(document.getElementById('battery-circle')) {
                            let socVal = sensor.battery_soc;
                            let socColor = socVal > 30 ? '#079844' : (socVal > 15 ? '#F59E0B' : '#EF4444');
                            let emptyColor = document.documentElement.classList.contains('dark') ? '#334155' : '#f3f4f6';
                            document.getElementById('battery-circle').style.background = `conic-gradient(${socColor} ${socVal}%, ${emptyColor} 0)`;
                        }
                    }
                } catch (error) {
                    console.error("Live data fetch error:", error);
                }
            }, 5000);
            
            // Sidebar time update
            const sidebarTimeEl = document.getElementById('sidebar-time');
            if (sidebarTimeEl) {
                const sidebarTimeUrl = "{{ route('api.live') }}";
                async function refreshSidebarTime() {
                    try {
                        const response = await fetch(sidebarTimeUrl, {cache: 'no-store'});
                        const payload = await response.json();
                        if (payload?.data?.server_time) sidebarTimeEl.innerText = payload.data.server_time;
                    } catch (error) {}
                }
                refreshSidebarTime();
                setInterval(refreshSidebarTime, 1000);
            }
            
            // Auto-refresh page based on settings
            const refreshSeconds = {{ isset($globalSettings['refresh_interval']) ? (int) $globalSettings['refresh_interval'] : 30 }};
            const currentPath = window.location.pathname;
            const isSettingsPage = currentPath.includes('/settings');
            const isDashboardPage = currentPath === '/' || currentPath.includes('/dashboard');
            if (refreshSeconds > 0 && !isSettingsPage && !isDashboardPage) {
                setInterval(() => window.location.reload(), refreshSeconds * 1000);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
