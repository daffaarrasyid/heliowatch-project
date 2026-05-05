@extends('layouts.app')
@section('title', 'Scenario Simulation')

@section('content')
<!-- Header -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 opacity-0 animate-fade-in-down">
    <div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-1 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            Scenario Simulation
        </h2>
        <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400 mt-2">Test how your microgrid responds under different operational scenarios.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2 md:gap-4">
        <div class="bg-white dark:bg-slate-800 px-3 md:px-4 py-2 rounded-full shadow-sm text-xs md:text-sm font-medium border border-gray-100 dark:border-slate-700 flex items-center gap-2 transition-colors">
            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span id="current-time" class="dark:text-slate-300">{{ \Carbon\Carbon::now($globalSettings['timezone'] ?? 'Asia/Jakarta')->translatedFormat('d M Y • H:i') }} WIB</span>
        </div>

        <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 shadow-sm text-sm font-medium border border-gray-100 dark:border-slate-700 text-gray-700 dark:text-slate-300 transition-colors">
            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.5 8.5 0 100-17 8.5 8.5 0 000 17z"></path></svg>
            <span>{{ $globalSettings['site_name'] ?? 'Island Microgrid 1' }}</span>
        </div>

        <button class="bg-white dark:bg-slate-800 p-2 rounded-full shadow-sm border border-gray-100 dark:border-slate-700 text-[#005DCE] dark:text-indigo-400 hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors relative">
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white dark:border-slate-800 rounded-full hidden"></span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </button>
    </div>
</header>

<!-- Scenario Selector -->
<form method="GET" action="{{ route('simulation') }}" id="scenarioForm">
    <p class="font-bold text-gray-900 dark:text-slate-100 mb-3 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">Choose a scenario to simulate</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s;">
        <!-- Normal -->
        <label class="cursor-pointer">
            <input type="radio" name="scenario" value="normal" class="peer hidden" onchange="document.getElementById('scenarioForm').submit()" {{ $scenario == 'normal' ? 'checked' : '' }}>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border-2 {{ $scenario == 'normal' ? 'border-indigo-500 bg-indigo-50/20 dark:bg-indigo-900/20 shadow-md' : 'border-gray-100 dark:border-slate-700 hover:border-gray-200 dark:hover:border-slate-600' }} flex gap-4 items-center transition-all h-full">
                <div class="w-10 h-10 rounded-full {{ $scenario == 'normal' ? 'bg-indigo-500 text-white' : 'bg-gray-100 dark:bg-slate-900 text-gray-400 dark:text-slate-300' }} flex items-center justify-center shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold {{ $scenario == 'normal' ? 'text-indigo-900 dark:text-indigo-200' : 'text-gray-800 dark:text-slate-100' }}">Normal Operation</h3>
                    <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-tight mt-1">Typical day with expected conditions</p>
                </div>
            </div>
        </label>

        <!-- Cloud Cover -->
        <label class="cursor-pointer">
            <input type="radio" name="scenario" value="cloud_cover" class="peer hidden" onchange="document.getElementById('scenarioForm').submit()" {{ $scenario == 'cloud_cover' ? 'checked' : '' }}>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border-2 {{ $scenario == 'cloud_cover' ? 'border-indigo-500 bg-indigo-50/20 dark:bg-indigo-900/20 shadow-md' : 'border-gray-100 dark:border-slate-700 hover:border-gray-200 dark:hover:border-slate-600' }} flex gap-4 items-center transition-all h-full">
                <div class="w-10 h-10 rounded-full {{ $scenario == 'cloud_cover' ? 'bg-indigo-500 text-white' : 'bg-gray-100 dark:bg-slate-900 text-gray-500 dark:text-slate-300' }} flex items-center justify-center shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold {{ $scenario == 'cloud_cover' ? 'text-indigo-900 dark:text-indigo-200' : 'text-gray-800 dark:text-slate-100' }}">Sudden Cloud Cover</h3>
                    <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-tight mt-1">Rapid drop in solar generation</p>
                </div>
            </div>
        </label>

        <!-- Load Spike -->
        <label class="cursor-pointer">
            <input type="radio" name="scenario" value="load_spike" class="peer hidden" onchange="document.getElementById('scenarioForm').submit()" {{ $scenario == 'load_spike' ? 'checked' : '' }}>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border-2 {{ $scenario == 'load_spike' ? 'border-indigo-500 bg-indigo-50/20 dark:bg-indigo-900/20 shadow-md' : 'border-gray-100 dark:border-slate-700 hover:border-gray-200 dark:hover:border-slate-600' }} flex gap-4 items-center transition-all h-full">
                <div class="w-10 h-10 rounded-full {{ $scenario == 'load_spike' ? 'bg-indigo-500 text-white' : 'bg-orange-50 dark:bg-orange-500/10 text-orange-500 dark:text-orange-200' }} flex items-center justify-center shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold {{ $scenario == 'load_spike' ? 'text-indigo-900 dark:text-indigo-200' : 'text-gray-800 dark:text-slate-100' }}">Community Load Spike</h3>
                    <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-tight mt-1">Unexpected increase in community demand</p>
                </div>
            </div>
        </label>

        <!-- Critical -->
        <label class="cursor-pointer">
            <input type="radio" name="scenario" value="critical" class="peer hidden" onchange="document.getElementById('scenarioForm').submit()" {{ $scenario == 'critical' ? 'checked' : '' }}>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border-2 {{ $scenario == 'critical' ? 'border-red-500 bg-red-50/20 dark:bg-rose-900/20 shadow-md' : 'border-gray-100 dark:border-slate-700 hover:border-gray-200 dark:hover:border-slate-600' }} flex gap-4 items-center transition-all h-full">
                <div class="w-10 h-10 rounded-full {{ $scenario == 'critical' ? 'bg-red-500 text-white' : 'bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-200' }} flex items-center justify-center shrink-0 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold {{ $scenario == 'critical' ? 'text-red-900 dark:text-red-200' : 'text-gray-800 dark:text-slate-100' }}">Late-Afternoon Critical Event</h3>
                    <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-tight mt-1">High load + low solar late in the day</p>
                </div>
            </div>
        </label>
    </div>
</form>

@php
    // Inisialisasi variabel supaya kode Blade gampang dibaca
    $simKpi = $kpiData['simulation_data']['kpi'] ?? ['ramp_risk' => 0.28, 'ens' => 0.0, 'soc' => 65, 'srs' => 95, 'srs_exp' => 95];
    $impact = $kpiData['simulation_data']['impact'] ?? [
        'baseline' => ['ramp_risk' => 0.28, 'ens' => 0.0, 'soc' => 65],
        'optimized' => ['ramp_risk' => 0.20, 'ens' => 0.0, 'soc' => 70]
    ];
@endphp

<!-- Main Simulation Content Row -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s;">
    
    <!-- Big Chart Area -->
    <div class="lg:col-span-3 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                Simulation Overview – {{ ucwords(str_replace('_', ' ', $scenario)) }}
            </h3>
            
            <!-- DYNAMIC METRIC DROPDOWN -->
            <div class="relative">
                <select id="metricFilter" class="appearance-none bg-white dark:bg-slate-800 dark:text-slate-300 pl-3 pr-8 py-1.5 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-medium text-gray-600 outline-none hover:border-gray-300 dark:hover:border-slate-600 transition-colors cursor-pointer">
                    <option value="all">Show: All Metrics</option>
                    <option value="pv_load">PV & Load Demand Only</option>
                    <option value="battery">Battery Dynamics Only</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400 dark:text-slate-500">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <!-- Custom Legend -->
        <div class="flex flex-wrap items-center gap-6 mb-2 px-2 text-[11px] font-bold text-gray-600 dark:text-slate-300">
            <div class="flex items-center gap-2"><span class="w-4 border-t-2 border-dashed border-indigo-500"></span> PV Forecast</div>
            <div class="flex items-center gap-2"><span class="w-4 border-t-2 border-dashed border-orange-400"></span> Load Forecast</div>
            <div class="flex items-center gap-2"><span class="w-4 h-2 bg-green-200 rounded-sm"></span> Battery Discharge (Support)</div>
            <div class="flex items-center gap-2"><span class="w-4 border-t-2 border-indigo-700"></span> Battery SOC (%)</div>
        </div>

        <div class="h-72 w-full relative mt-4">
            <canvas id="simulationChart"></canvas>
        </div>
    </div>

    <!-- Right Side KPIs -->
    <div class="lg:col-span-1 space-y-4">
        <!-- Predicted Ramp Risk -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-6 h-6 rounded-full bg-red-50 dark:bg-rose-500/10 text-red-500 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h4 class="text-[11px] font-bold text-gray-600">Predicted Ramp Risk</h4>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-2xl font-bold {{ $simKpi['ramp_risk'] > 0.70 ? 'text-red-500' : 'text-gray-900 dark:text-slate-100' }}">{{ $simKpi['ramp_risk'] }}</p>
                    <p class="text-[10px] font-bold {{ $simKpi['ramp_risk'] > 0.70 ? 'text-red-500' : 'text-green-500' }} mb-1">{{ $simKpi['ramp_risk'] > 0.70 ? 'High' : 'Normal' }}</p>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-slate-500">Threshold: 0.50</p>
            </div>
            <div class="w-16 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,40 Q20,40 30,20 T60,30 T100,10" fill="none" stroke="{{ $simKpi['ramp_risk'] > 0.70 ? '#EF4444' : '#10B981' }}" stroke-width="3" stroke-linecap="round"/></svg></div>
        </div>

        <!-- Estimated ENS -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-6 h-6 rounded-full bg-orange-50 dark:bg-amber-500/10 text-orange-500 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-[11px] font-bold text-gray-600">Estimated ENS</h4>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-2xl font-bold {{ $simKpi['ens'] > 0 ? 'text-orange-500' : 'text-gray-900 dark:text-slate-100' }}">{{ $simKpi['ens'] }} <span class="text-xs font-normal text-gray-500 dark:text-slate-500">kWh</span></p>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-slate-500">Threshold: 100 kWh</p>
            </div>
            <div class="w-16 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,35 Q20,35 40,25 T70,30 T100,15" fill="none" stroke="{{ $simKpi['ens'] > 0 ? '#F59E0B' : '#10B981' }}" stroke-width="3" stroke-linecap="round"/></svg></div>
        </div>

        <!-- Battery Reserve Margin -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-6 h-6 rounded-full bg-green-50 dark:bg-emerald-500/10 text-green-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm0 0V4m16 2v-2M8 12h8"></path></svg>
                    </div>
                    <h4 class="text-[11px] font-bold text-gray-600">Battery Reserve Margin</h4>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-2xl font-bold {{ $simKpi['soc'] < 20 ? 'text-red-500' : 'text-gray-900 dark:text-slate-100' }}">{{ $simKpi['soc'] }}%</p>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-slate-500">Threshold: 20%</p>
            </div>
            <div class="w-16 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,40 Q25,40 40,20 T75,30 T100,15" fill="none" stroke="{{ $simKpi['soc'] < 20 ? '#EF4444' : '#10B981' }}" stroke-width="3" stroke-linecap="round"/></svg></div>
        </div>

        <!-- Solar Reliability Score -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex justify-between items-center transform hover:-translate-y-1 transition-transform">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-6 h-6 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-[11px] font-bold text-gray-600">Solar Reliability</h4>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-2xl font-bold {{ $simKpi['srs'] < 70 ? 'text-red-500' : 'text-gray-900 dark:text-slate-100' }}">{{ $simKpi['srs'] }} <span class="text-xs font-normal text-gray-400 dark:text-slate-500">/100</span></p>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-slate-500">Expected: {{ $simKpi['srs_exp'] }} /100</p>
            </div>
            <div class="w-16 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,45 Q15,45 30,25 T65,30 T100,10" fill="none" stroke="#4F46E5" stroke-width="3" stroke-linecap="round"/></svg></div>
        </div>
    </div>
</div>

<!-- Bottom Row: Impact & Notes -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 pb-8 opacity-0 animate-fade-in-up" style="animation-delay: 0.4s;">
    
    <!-- Impact Comparison -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 h-full flex flex-col justify-between">
        <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm mb-4 flex items-center gap-1">
            Impact Comparison <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </h3>
        
        <div class="flex flex-col sm:flex-row gap-4 items-center mb-4">
            <!-- Without Action Box -->
            <div class="flex-1 bg-red-50/30 dark:bg-rose-500/10 border border-red-100 dark:border-rose-500/20 rounded-xl p-4 w-full relative overflow-hidden">
                <h4 class="text-xs font-bold text-red-500 dark:text-rose-300 mb-3">Without Action<br><span class="text-[10px] font-normal text-gray-500 dark:text-slate-400">(Current Projection)</span></h4>
                <div class="flex justify-between">
                    <div>
                        <p class="text-[9px] text-gray-500">Max Ramp Risk (60 min)</p>
                        <p class="text-lg font-bold text-red-500">{{ $impact['baseline']['ramp_risk'] }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500">Estimated ENS</p>
                        <p class="text-lg font-bold text-orange-500">{{ $impact['baseline']['ens'] }} <span class="text-xs font-normal">kWh</span></p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-[9px] text-gray-500">Min Battery SOC</p>
                    <p class="text-lg font-bold text-red-500">{{ $impact['baseline']['soc'] }}%</p>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-8 opacity-30">
                    <svg viewBox="0 0 100 20" preserveAspectRatio="none" class="w-full h-full"><path d="M0,20 L0,10 Q25,15 50,5 T100,10 L100,20 Z" fill="#EF4444"/></svg>
                </div>
            </div>

            <!-- VS Badge -->
            <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-900 flex items-center justify-center font-bold text-gray-400 dark:text-slate-400 text-[10px] shrink-0 z-10">VS</div>

            <!-- With Action Box -->
            <div class="flex-1 bg-green-50/30 dark:bg-emerald-500/10 border border-green-100 dark:border-emerald-500/20 rounded-xl p-4 w-full relative overflow-hidden">
                <h4 class="text-xs font-bold text-green-600 dark:text-emerald-300 mb-3">With Recommended Action<br><span class="text-[10px] font-normal text-gray-500 dark:text-slate-400">(After Simulation)</span></h4>
                <div class="flex justify-between">
                    <div>
                        <p class="text-[9px] text-gray-500">Max Ramp Risk</p>
                        <p class="text-lg font-bold text-green-600">{{ $impact['optimized']['ramp_risk'] }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-gray-500">Estimated ENS</p>
                        <p class="text-lg font-bold text-green-600">{{ $impact['optimized']['ens'] }} <span class="text-xs font-normal">kWh</span></p>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-[9px] text-gray-500">Min Battery SOC</p>
                    <p class="text-lg font-bold text-green-600">{{ $impact['optimized']['soc'] }}%</p>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-8 opacity-30">
                    <svg viewBox="0 0 100 20" preserveAspectRatio="none" class="w-full h-full"><path d="M0,20 L0,15 Q25,20 50,10 T100,15 L100,20 Z" fill="#10B981"/></svg>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center text-[11px] pt-3 border-t border-gray-100">
            <p class="flex items-center gap-1 text-gray-500 font-medium">
                <svg class="w-4 h-4 {{ $impact['baseline']['ramp_risk'] > $impact['optimized']['ramp_risk'] ? 'text-green-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $impact['baseline']['ramp_risk'] > $impact['optimized']['ramp_risk'] ? 'Recommended actions significantly improve system reliability.' : 'Current strategy is optimal.' }}
            </p>
            <a href="{{ route('alerts') }}" class="font-bold text-indigo-600 hover:underline flex items-center">View Actions <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>
    </div>

    <!-- Scenario Notes (Lebih Lebar karena Controls dihapus) -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col h-full">
        <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Scenario Notes & Parameters
        </h3>
        
        <p class="text-[12px] text-gray-600 mb-6 leading-relaxed flex-1 border-b border-gray-100 pb-4">
            <span class="font-bold text-indigo-700 block mb-1">Scenario Details:</span>
            {{ $scenarioDetails['desc'] }}
        </p>
        
        <div class="grid grid-cols-2 gap-x-6 gap-y-3 mt-auto">
            <div class="flex items-center text-[11px] bg-gray-50 dark:bg-slate-900 p-2 rounded-lg">
                <span class="w-24 text-gray-500 dark:text-slate-400 font-bold flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Date</span>
                <span class="text-gray-800 dark:text-slate-200 flex-1 text-right">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</span>
            </div>
            <div class="flex items-center text-[11px] bg-gray-50 dark:bg-slate-900 p-2 rounded-lg">
                <span class="w-24 text-gray-500 dark:text-slate-400 font-bold flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg> Weather</span>
                <span class="text-gray-800 dark:text-slate-200 flex-1 text-right">{{ $scenarioDetails['weather'] }}</span>
            </div>
            <div class="flex items-center text-[11px] bg-gray-50 dark:bg-slate-900 p-2 rounded-lg">
                <span class="w-24 text-gray-500 dark:text-slate-400 font-bold flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Demand</span>
                <span class="text-gray-800 dark:text-slate-200 flex-1 text-right">{{ $scenarioDetails['demand'] }}</span>
            </div>
            <div class="flex items-center text-[11px] bg-indigo-50/50 dark:bg-slate-900 border border-indigo-100 dark:border-slate-700 p-2 rounded-lg">
                <span class="w-24 text-indigo-600 dark:text-indigo-300 font-bold flex items-center gap-1"><svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2zm0 0V4m16 2v-2M8 12h8"></path></svg> Strategy</span>
                <span class="text-indigo-800 dark:text-indigo-200 font-bold flex-1 text-right">{{ $scenarioDetails['strategy'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('simulationChart').getContext('2d');
        
        const generateChartData = (scenarioStr) => {
            const labels = [];
            for (let i = 0; i <= 24; i += 1) {
                labels.push(`${i.toString().padStart(2, '0')}:00`);
            }

            let pvForecast = [];
            let loadForecast = [];
            let batteryDischarge = [];
            let soc = [];

            for (let i = 0; i <= 24; i++) {
                let pv = 0;
                if(i > 6 && i < 18) { pv = 40 * Math.sin(Math.PI * (i - 6) / 12) + (Math.random() * 5); }
                let load = 15 + Math.abs(Math.sin(Math.PI * (i) / 12)) * 10;
                
                if(scenarioStr === 'cloud_cover' && i >= 10 && i <= 14) { pv = pv * 0.3; }
                if(scenarioStr === 'load_spike' && i >= 14 && i <= 19) { load = load * 1.8; }
                if(scenarioStr === 'critical' && i > 6) { pv = pv * 0.5; if(i >= 15) load = load * 1.5; }

                pvForecast.push(pv);
                loadForecast.push(load);
                
                let deficit = load - pv;
                let discharge = deficit > 0 ? Math.min(deficit, 25) : 0;
                batteryDischarge.push(discharge);

                let currentSoc = i === 0 ? 80 : soc[i-1];
                if(deficit < 0) { currentSoc = Math.min(100, currentSoc + Math.abs(deficit)*0.5); } 
                else { currentSoc = Math.max(0, currentSoc - discharge*0.8); }
                soc.push(currentSoc);
            }
            return { labels, pvForecast, loadForecast, batteryDischarge, soc };
        };

        const currentScenario = "{{ $scenario }}";
        const simData = generateChartData(currentScenario);

        let gradientGreen = ctx.createLinearGradient(0, 0, 0, 300);
        gradientGreen.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
        gradientGreen.addColorStop(1, 'rgba(16, 185, 129, 0)');

        window.simChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: simData.labels,
                datasets: [
                    { label: 'PV Forecast', data: simData.pvForecast, borderColor: '#6366F1', borderWidth: 2, borderDash: [5, 5], pointRadius: 0, tension: 0.4, yAxisID: 'y', hidden: false },
                    { label: 'Load Forecast', data: simData.loadForecast, borderColor: '#F59E0B', borderWidth: 2, borderDash: [5, 5], pointRadius: 0, tension: 0.4, yAxisID: 'y', hidden: false },
                    { label: 'Battery Discharge', data: simData.batteryDischarge, borderColor: '#10B981', backgroundColor: gradientGreen, borderWidth: 1, pointRadius: 0, fill: true, tension: 0.4, yAxisID: 'y', hidden: false },
                    { label: 'Battery SOC', data: simData.soc, borderColor: '#4338CA', borderWidth: 2, pointRadius: 0, tension: 0.4, yAxisID: 'y1', hidden: false }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1f2937', padding: 10, cornerRadius: 8 } },
                scales: {
                    y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'kW', color: '#9ca3af', font: {size: 10} }, beginAtZero: true, max: 60, grid: { color: '#f3f4f6' }, ticks: { color: '#9ca3af' } },
                    y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'SOC (%)', color: '#9ca3af', font: {size: 10} }, beginAtZero: true, max: 100, grid: { display: false }, ticks: { color: '#9ca3af' } },
                    x: { grid: { display: false }, ticks: { color: '#9ca3af', maxTicksLimit: 8 } }
                }
            }
        });

        // Metric filter dropdown
        document.getElementById('metricFilter').addEventListener('change', function(e) {
            const val = e.target.value;
            const chart = window.simChart;
            
            if(val === 'all') {
                chart.data.datasets.forEach(ds => ds.hidden = false);
            } else if(val === 'pv_load') {
                chart.data.datasets[0].hidden = false; // PV
                chart.data.datasets[1].hidden = false; // Load
                chart.data.datasets[2].hidden = true;  // Bat Discharge
                chart.data.datasets[3].hidden = true;  // SOC
            } else if(val === 'battery') {
                chart.data.datasets[0].hidden = true;
                chart.data.datasets[1].hidden = true;
                chart.data.datasets[2].hidden = false;
                chart.data.datasets[3].hidden = false;
            }
            chart.update(); 
        });
    });
</script>
@endpush