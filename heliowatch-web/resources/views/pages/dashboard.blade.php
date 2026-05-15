@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <!-- Header -->
    <header
        class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 opacity-0 animate-fade-in-down">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-1 transition-colors">
                Hello, {{ $globalSettings['operator_name'] ?? 'Operator' }} 👋
            </h2>
            <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Here's your microgrid overview and operational
                insights.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 md:gap-4">
            <div
                class="bg-white dark:bg-slate-800 px-3 md:px-4 py-2 rounded-full shadow-sm text-xs md:text-sm font-medium border border-gray-100 dark:border-slate-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span id="current-time"
                    class="dark:text-slate-300">{{ \Carbon\Carbon::now($globalSettings['timezone'] ?? 'Asia/Jakarta')->translatedFormat('d M Y • H:i') }}
                    WIB</span>
            </div>

            <div
                class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 shadow-sm border border-gray-100 dark:border-slate-700 text-sm font-medium text-gray-700 dark:text-slate-300 transition-colors">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.5 8.5 0 100-17 8.5 8.5 0 000 17z"></path>
                </svg>
                <span>{{ $globalSettings['site_name'] ?? 'Island Microgrid 1' }}</span>
            </div>

            <button
                class="bg-white dark:bg-slate-800 p-2 rounded-full shadow-sm border border-gray-100 dark:border-slate-700 text-[#005DCE] dark:text-indigo-400 hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors relative">
                <span
                    class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-slate-800 rounded-full hidden"></span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </button>
        </div>
    </header>

    <!-- KPI Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
        <!-- Card 1: Solar Reliability Score -->
        <div class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300 opacity-0 animate-fade-in-up"
            style="animation-delay: 0.1s;">
            <div class="flex items-center gap-2 mb-3">
                <div
                    class="w-8 h-8 shrink-0 rounded-lg bg-[#E4F5FE] dark:bg-indigo-900/30 text-[#005DCE] dark:text-indigo-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Solar Reliability Score</h3>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <p class="text-2xl md:text-3xl font-bold text-[#005DCE] dark:text-indigo-400"><span
                            id="val-srs">{{ $kpiData['reliability_score'] ?? 0 }}</span> <span
                            class="text-xs md:text-sm font-normal text-gray-400 dark:text-slate-500">/100</span></p>
                    <p id="status-srs"
                        class="text-[10px] md:text-xs font-medium mt-1 {{ ($kpiData['reliability_score'] ?? 0) >= 80 ? 'text-[#079844] dark:text-emerald-400' : 'text-[#F59E0B] dark:text-amber-400' }}">
                        ● {{ $kpiData['reliability_status'] ?? 'Unknown' }}</p>
                </div>
                <div class="w-20 md:w-24 h-8 md:h-10 -mb-1">
                    <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                        <path d="M0,40 C15,40 20,25 35,30 C50,35 60,15 75,20 C85,25 90,35 100,30" fill="none"
                            stroke="currentColor" class="text-[#005DCE] dark:text-indigo-400" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Ramp Risk -->
        <div class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300 opacity-0 animate-fade-in-up"
            style="animation-delay: 0.2s;">
            <div class="flex items-center gap-2 mb-3">
                <div
                    class="w-8 h-8 shrink-0 rounded-lg bg-red-50 dark:bg-rose-900/30 text-red-500 dark:text-rose-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Ramp Risk (60 min)</h3>
            </div>
            <div class="mt-2 text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full inline-block">
                AI Confidence: <span id="ai-confidence-display">--%</span>
            </div>
            <div class="text-[10px] text-gray-400 mt-1">
                Horizon: <span id="lead-time-display">--</span>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <p id="val-ramp"
                        class="text-2xl md:text-3xl font-bold {{ isset($kpiData['is_ramp_alert']) && $kpiData['is_ramp_alert'] ? 'text-red-500 dark:text-rose-400' : 'text-[#079844] dark:text-emerald-400' }}">
                        {{ $kpiData['ramp_risk'] ?? 0.0 }}</p>
                    <p id="status-ramp"
                        class="text-[10px] md:text-xs font-medium mt-1 {{ isset($kpiData['is_ramp_alert']) && $kpiData['is_ramp_alert'] ? 'text-red-500 dark:text-rose-400 animate-pulse' : 'text-[#079844] dark:text-emerald-400' }}">
                        ● {{ isset($kpiData['is_ramp_alert']) && $kpiData['is_ramp_alert'] ? 'High Risk' : 'Normal' }}</p>
                </div>
                <div class="w-20 md:w-24 h-8 md:h-10 -mb-1">
                    <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                        <path d="M0,35 C15,45 25,45 40,35 C55,25 65,15 80,25 C90,30 95,40 100,35" fill="none"
                            stroke="currentColor" class="text-red-500 dark:text-rose-500" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Battery Reserve Margin -->
        <div class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300 opacity-0 animate-fade-in-up"
            style="animation-delay: 0.3s;">
            <div class="flex items-center gap-2 mb-3">
                <div
                    class="w-8 h-8 shrink-0 rounded-lg bg-green-50 dark:bg-emerald-900/30 text-[#079844] dark:text-emerald-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm0 0V4m16 2v-2M8 12h8">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Battery Reserve Margin</h3>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <p class="text-2xl md:text-3xl font-bold text-[#079844] dark:text-emerald-400"><span
                            id="val-bat-margin">{{ $kpiData['battery_margin'] ?? 0 }}</span>%</p>
                    <p id="status-bat-margin"
                        class="text-[10px] md:text-xs font-medium mt-1 {{ isset($kpiData['is_soc_alert']) && $kpiData['is_soc_alert'] ? 'text-red-500 dark:text-rose-400' : 'text-[#F59E0B] dark:text-amber-400' }}">
                        ● {{ isset($kpiData['is_soc_alert']) && $kpiData['is_soc_alert'] ? 'Low' : 'Moderate' }}</p>
                </div>
                <div class="w-20 md:w-24 h-8 md:h-10 -mb-1">
                    <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                        <path d="M0,45 C20,45 30,25 50,30 C65,35 75,10 90,15 C95,18 98,25 100,25" fill="none"
                            stroke="currentColor" class="text-[#079844] dark:text-emerald-500" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Est. Energy Not Served -->
        <div class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300 opacity-0 animate-fade-in-up"
            style="animation-delay: 0.4s;">
            <div class="flex items-center gap-2 mb-3">
                <div
                    class="w-8 h-8 shrink-0 rounded-lg bg-yellow-50 dark:bg-amber-900/30 text-[#F59E0B] dark:text-amber-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Est. Energy Not Served</h3>
            </div>
            <div class="flex items-end justify-between mt-2">
                <div>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-slate-100"><span
                            id="val-ens">{{ $kpiData['energy_not_served'] ?? 0.0 }}</span> <span
                            class="text-xs md:text-sm font-normal text-gray-400 dark:text-slate-500">kWh</span></p>
                    <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-500 font-medium mt-1">Today</p>
                </div>
                <div class="w-20 md:w-24 h-8 md:h-10 -mb-1">
                    <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                        <path d="M0,35 C15,25 25,40 40,30 C55,20 65,10 80,20 C90,25 95,30 100,25" fill="none"
                            stroke="currentColor" class="text-[#F59E0B] dark:text-amber-500" stroke-width="2.5"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Snapshot Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.5s;">
        <!-- Main Chart Area -->
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transform hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#005DCE] dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    PV Power Forecast
                </h3>
                <div class="relative">
                    <select id="forecast-filter"
                        class="appearance-none bg-white dark:bg-slate-800 dark:text-slate-300 pl-4 pr-10 py-2 rounded-full border border-gray-200 dark:border-slate-600 text-xs font-medium text-gray-600 outline-none hover:border-gray-300 dark:hover:border-slate-500 transition-colors cursor-pointer">
                        <option value="4">Next 4 Hours</option>
                        <option value="8" selected>Next 8 Hours</option>
                        <option value="12">Next 12 Hours</option>
                        <option value="24">Next 24 Hours</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400 dark:text-slate-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="h-64 w-full relative">
                <canvas id="pvForecastChart"></canvas>
            </div>
        </div>

        <!-- System Snapshot List -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transform hover:shadow-md transition-all duration-300">
            <h3 class="font-bold text-gray-800 dark:text-slate-100 mb-4">System Snapshot</h3>
            <ul class="space-y-3">
                <li
                    class="flex justify-between items-center text-sm bg-gray-50 dark:bg-slate-900/50 hover:bg-blue-50/50 dark:hover:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700 transition-colors">
                    <span class="flex items-center gap-3 text-gray-700 dark:text-slate-300 font-medium">
                        <span
                            class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center bg-[#E4F5FE] dark:bg-indigo-900/30 text-[#005DCE] dark:text-indigo-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </span> PV Output (Now)
                    </span>
                    <span class="font-bold text-gray-900 dark:text-slate-100"><span
                            id="val-pv-out">{{ $kpiData['sensor_snapshot']['current_pv_output'] ?? 0 }}</span> kW</span>
                </li>
                <li
                    class="flex justify-between items-center text-sm bg-gray-50 dark:bg-slate-900/50 hover:bg-yellow-50/50 dark:hover:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700 transition-colors">
                    <span class="flex items-center gap-3 text-gray-700 dark:text-slate-300 font-medium">
                        <span
                            class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center bg-yellow-50 dark:bg-amber-900/30 text-[#F59E0B] dark:text-amber-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </span> Load (Now)
                    </span>
                    <span class="font-bold text-gray-900 dark:text-slate-100"><span
                            id="val-load">{{ $kpiData['sensor_snapshot']['current_load'] ?? 0 }}</span> kW</span>
                </li>
                <li
                    class="flex justify-between items-center text-sm bg-gray-50 dark:bg-slate-900/50 hover:bg-green-50/50 dark:hover:bg-slate-700/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700 transition-colors">
                    <span class="flex items-center gap-3 text-gray-700 dark:text-slate-300 font-medium">
                        <span
                            class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center bg-green-50 dark:bg-emerald-900/30 text-[#079844] dark:text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm0 0V4m16 2v-2M8 12h8">
                                </path>
                            </svg>
                        </span> Battery SOC
                    </span>
                    <span class="font-bold text-gray-900 dark:text-slate-100"><span
                            id="val-snap-soc">{{ $kpiData['sensor_snapshot']['battery_soc'] ?? 0 }}</span>%</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Actions and Battery Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-8 opacity-0 animate-fade-in-up" style="animation-delay: 0.6s;">
        <!-- Recommended Actions -->
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col transform hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#005DCE] dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    Active Status & Recommendations
                </h3>
            </div>
            <div class="space-y-3 flex-1">
                <!-- Alert Merah: Ramp Risk -->
                <div id="alert-ramp"
                    class="{{ isset($kpiData['is_ramp_alert']) && $kpiData['is_ramp_alert'] ? 'flex' : 'hidden' }} items-start justify-between bg-red-50 dark:bg-rose-500/10 hover:bg-red-100/50 dark:hover:bg-rose-500/20 p-4 rounded-xl border border-red-100 dark:border-rose-500/20 transition-colors cursor-pointer group">
                    <div class="flex gap-3">
                        <div class="mt-0.5 text-red-500 dark:text-rose-400 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-slate-200">High ramp risk detected!</h4>
                            <p class="text-xs text-gray-600 dark:text-slate-400 mt-1">Consider increasing battery discharge
                                or preparing load shedding.</p>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold text-red-600 dark:text-rose-400 bg-red-100 dark:bg-rose-500/20 px-2 py-1 rounded-md">Priority:
                        High</span>
                </div>

                <!-- Alert Kuning: SOC Low -->
                <div id="alert-soc"
                    class="{{ isset($kpiData['is_soc_alert']) && $kpiData['is_soc_alert'] ? 'flex' : 'hidden' }} items-start justify-between bg-yellow-50 dark:bg-amber-500/10 hover:bg-yellow-100/50 dark:hover:bg-amber-500/20 p-4 rounded-xl border border-yellow-100 dark:border-amber-500/20 transition-colors cursor-pointer group">
                    <div class="flex gap-3">
                        <div class="mt-0.5 text-[#F59E0B] dark:text-amber-400 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-slate-200">Battery reserve is getting
                                lower.</h4>
                            <p class="text-xs text-gray-600 dark:text-slate-400 mt-1">Delay non-essential loads if
                                possible.</p>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold text-yellow-700 dark:text-amber-500 bg-yellow-100/80 dark:bg-amber-500/20 px-2 py-1 rounded-md">Priority:
                        Medium</span>
                </div>

                <!-- Alert Hijau: Normal -->
                <div id="alert-normal"
                    class="{{ !(isset($kpiData['is_ramp_alert']) && $kpiData['is_ramp_alert']) && !(isset($kpiData['is_soc_alert']) && $kpiData['is_soc_alert']) ? 'flex' : 'hidden' }} items-start justify-between bg-[#E6F4EA]/50 dark:bg-emerald-500/10 hover:bg-[#E6F4EA] dark:hover:bg-emerald-500/20 p-4 rounded-xl border border-green-100 dark:border-emerald-500/20 transition-colors cursor-pointer group">
                    <div class="flex gap-3">
                        <div
                            class="mt-0.5 text-[#079844] dark:text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-slate-200">System condition is normal.
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-slate-400 mt-1">Continue monitoring.</p>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold text-[#079844] dark:text-emerald-400 bg-[#E6F4EA] dark:bg-emerald-500/20 px-2 py-1 rounded-md border border-green-200 dark:border-transparent">Priority:
                        Low</span>
                </div>
            </div>
        </div>

        <!-- Battery Status -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transform hover:shadow-md transition-all duration-300">
            <h3 class="font-bold text-gray-800 dark:text-slate-100 mb-4">Battery Status</h3>
            <div class="flex justify-center mb-6">
                <div id="battery-circle"
                    class="w-32 h-32 rounded-full flex items-center justify-center relative hover:scale-105 transition-transform duration-500 shadow-inner"
                    style="background: conic-gradient(#079844 {{ $kpiData['sensor_snapshot']['battery_soc'] ?? 0 }}%, transparent 0);">
                    <div
                        class="w-28 h-28 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center absolute transition-colors duration-300">
                        <div class="text-center">
                            <span class="block text-3xl font-bold text-gray-800 dark:text-slate-100"><span
                                    id="val-circle-soc">{{ $kpiData['sensor_snapshot']['battery_soc'] ?? 0 }}</span>%</span>
                            <span class="block text-xs text-gray-500 dark:text-slate-400 font-medium">SOC</span>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="space-y-3">
                <li
                    class="flex justify-between text-sm items-center hover:bg-gray-50 dark:hover:bg-slate-700/50 p-1.5 rounded transition-colors">
                    <span class="text-gray-500 dark:text-slate-400">Charging Power</span>
                    <span class="font-bold text-[#079844] dark:text-emerald-400"><span
                            id="val-charge">{{ $kpiData['sensor_snapshot']['charging_power'] ?? 0 }}</span> kW</span>
                </li>
                <li
                    class="flex justify-between text-sm items-center hover:bg-gray-50 dark:hover:bg-slate-700/50 p-1.5 rounded transition-colors">
                    <span class="text-gray-500 dark:text-slate-400">Discharging Power</span>
                    <span class="font-bold text-red-500 dark:text-rose-400"><span
                            id="val-discharge">{{ $kpiData['sensor_snapshot']['discharging_power'] ?? 0 }}</span>
                        kW</span>
                </li>
            </ul>
            <div
                class="mt-5 bg-[#E6F4EA]/80 dark:bg-emerald-500/10 text-[#079844] dark:text-emerald-400 text-xs font-bold text-center py-2.5 rounded-xl border border-green-100 dark:border-emerald-500/20 flex items-center justify-center gap-2 cursor-default transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Battery is healthy
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // --- 1. INISIALISASI GRAFIK CHART.JS ---
            if (typeof Chart !== 'undefined') {
                const ctx = document.getElementById('pvForecastChart').getContext('2d');
                const isDark = document.documentElement.classList.contains('dark');

                let gradientCorrected = ctx.createLinearGradient(0, 0, 0, 300);
                gradientCorrected.addColorStop(0, isDark ? 'rgba(99, 102, 241, 0.3)' : 'rgba(0, 93, 206, 0.2)');
                gradientCorrected.addColorStop(1, 'rgba(0, 93, 206, 0)');

                // Data Master (Dibuat panjang 24 jam agar filter 12h & 24h bisa berjalan)
                const masterLabels = [
                    '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00',
                    '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00',
                    '00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00'
                ];
                const masterHistorical = [4.2, 8.5, 12.6, null, null, null, null, null, null, null, null, null,
                    null, null, null, null, null, null, null, null, null, null, null, null, null
                ];
                const masterPhysical = [null, null, 12.6, 14.2, 15.0, 14.8, 11.5, 7.2, 2.1, 0.8, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 1.2, 3.5, 6.1, 8.2
                ];
                const masterCorrected = [null, null, 12.6, 13.2, 14.0, 13.8, 11.5, 7.2, 2.1, 0.5, 0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 1.0, 3.0, 5.5, 8.0
                ];

                // Bikin Grafik (Default awal nampilin 8 jam sesuai slice 0-9)
                let pvForecastChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: masterLabels.slice(0, 9),
                        datasets: [{
                                label: 'Historical',
                                data: masterHistorical.slice(0, 9),
                                borderColor: '#9ca3af',
                                borderWidth: 2,
                                pointRadius: 0,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Forecast (Physical)',
                                data: masterPhysical.slice(0, 9),
                                borderColor: isDark ? '#818cf8' : '#79AFFF',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                pointRadius: 0,
                                fill: false,
                                tension: 0.4
                            },
                            {
                                label: 'Forecast (Corrected)',
                                data: masterCorrected.slice(0, 9),
                                borderColor: isDark ? '#6366f1' : '#005DCE',
                                backgroundColor: gradientCorrected,
                                borderWidth: 2,
                                pointBackgroundColor: isDark ? '#6366f1' : '#005DCE',
                                pointBorderColor: '#fff',
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    color: '#9ca3af',
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 20,
                                grid: {
                                    color: isDark ? 'rgba(156, 163, 175, 0.1)' : '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#9ca3af'
                                }
                            }
                        }
                    }
                });

                // --- 2. LOGIKA FILTER JAM (DROPDOWN) ---
                const filterDropdown = document.getElementById('forecast-filter');
                if (filterDropdown) {
                    filterDropdown.addEventListener('change', function(e) {
                        const hoursToShow = parseInt(e.target.value); // ngambil angka 4, 8, 12, atau 24

                        // Potong array master sesuai pilihan jam
                        pvForecastChart.data.labels = masterLabels.slice(0, hoursToShow + 1);
                        pvForecastChart.data.datasets[0].data = masterHistorical.slice(0, hoursToShow + 1);
                        pvForecastChart.data.datasets[1].data = masterPhysical.slice(0, hoursToShow + 1);
                        pvForecastChart.data.datasets[2].data = masterCorrected.slice(0, hoursToShow + 1);

                        // Perbarui tampilan grafik
                        pvForecastChart.update();
                    });
                }

            } else {
                console.error("Chart.js belum di-load! Pastikan CDN Chart.js ada di file app.blade.php");
            }

            // --- 3. SISTEM AUTO-REFRESH LIVE DATA TIAP 5 DETIK ---
            setInterval(function() {
                fetch('/live-data')
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success') {
                            let data = res.data;
                            let sensor = data.sensor_snapshot;

                            // Update Nilai Confidence & Horizon
                            let elConfidence = document.getElementById('ai-confidence-display');
                            let elHorizon = document.getElementById('lead-time-display');
                            if (elConfidence) elConfidence.innerText = (data.ai_confidence || '98.5') +
                                '%';
                            if (elHorizon) elHorizon.innerText = data.lead_time_horizon ||
                                '1 Hour (t+60)';

                            // Update Nilai Dashboard Lainnya (KPI)
                            if (document.getElementById('val-srs')) document.getElementById('val-srs')
                                .innerText = data.reliability_score;
                            if (document.getElementById('val-ramp')) document.getElementById('val-ramp')
                                .innerText = data.ramp_risk;
                            if (document.getElementById('val-bat-margin')) document.getElementById(
                                'val-bat-margin').innerText = data.battery_margin;
                            if (document.getElementById('val-ens')) document.getElementById('val-ens')
                                .innerText = data.energy_not_served;

                            // Update Sensor Real-time
                            if (document.getElementById('val-pv-out')) document.getElementById(
                                'val-pv-out').innerText = sensor.current_pv_output;
                            if (document.getElementById('val-load')) document.getElementById('val-load')
                                .innerText = sensor.current_load;
                            if (document.getElementById('val-snap-soc')) document.getElementById(
                                'val-snap-soc').innerText = sensor.battery_soc;
                            if (document.getElementById('val-circle-soc')) document.getElementById(
                                'val-circle-soc').innerText = sensor.battery_soc;
                            if (document.getElementById('val-charge')) document.getElementById(
                                'val-charge').innerText = sensor.charging_power;
                            if (document.getElementById('val-discharge')) document.getElementById(
                                'val-discharge').innerText = sensor.discharging_power;
                        }
                    })
                    .catch(err => console.log("Gagal mengambil data live:", err));
            }, 5000); // 5000ms = 5 detik

        });
    </script>
@endpush
