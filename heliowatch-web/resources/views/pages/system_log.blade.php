@extends('layouts.app')
@section('title', 'System Log')

@section('content')
<!-- Header -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4 opacity-0 animate-fade-in-down">
    <div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-1 flex items-center gap-2">
            System Log <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </h2>
        <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Historical system events, alerts, and operator actions for audit and performance tracking.</p>
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

<!-- KPI Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
    <!-- Card 1 -->
    <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
        <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-slate-900 text-blue-500 dark:text-blue-300 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
        <p class="text-[11px] font-bold text-gray-500 dark:text-slate-400 mb-1">Total Events Today</p>
        <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">{{ $kpi['total_events'] }}</p>
        <p class="text-[10px] font-bold text-blue-600 flex items-center gap-1">↑ {{ $kpi['total_trend'] }} vs yesterday</p>
        <div class="absolute bottom-2 right-2 w-20 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,40 Q20,40 40,20 T70,30 T100,10" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round"/></svg></div>
    </div>
    
    <!-- Card 2 -->
    <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
        <div class="w-10 h-10 rounded-lg bg-red-50 dark:bg-slate-900 text-red-500 dark:text-rose-300 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <p class="text-[11px] font-bold text-gray-500 dark:text-slate-400 mb-1">Critical Alerts</p>
        <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">{{ $kpi['critical_alerts'] }}</p>
        <p class="text-[10px] font-bold text-red-500 flex items-center gap-1">↑ {{ $kpi['critical_trend'] }} vs yesterday</p>
        <div class="absolute bottom-2 right-2 w-20 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,40 Q20,30 40,40 T70,20 T100,25" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round"/></svg></div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
        <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-slate-900 text-[#079844] dark:text-emerald-300 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <p class="text-[11px] font-bold text-gray-500 dark:text-slate-400 mb-1">Actions Executed</p>
        <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">{{ $kpi['actions_executed'] }}</p>
        <p class="text-[10px] font-bold text-[#079844] flex items-center gap-1">↑ {{ $kpi['actions_trend'] }} vs yesterday</p>
        <div class="absolute bottom-2 right-2 w-20 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,40 Q20,35 40,25 T70,30 T100,15" fill="none" stroke="#079844" stroke-width="2" stroke-linecap="round"/></svg></div>
    </div>

    <!-- Card 4 -->
    <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
        <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-slate-900 text-indigo-500 dark:text-indigo-300 flex items-center justify-center mb-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <p class="text-[11px] font-bold text-gray-500 dark:text-slate-400 mb-1">System Availability</p>
        <p class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">{{ $kpi['availability'] }}</p>
        <p class="text-[10px] font-bold text-indigo-500 flex items-center gap-1">↑ {{ $kpi['availability_trend'] }} vs yesterday</p>
        <div class="absolute bottom-2 right-2 w-20 h-8"><svg viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,45 Q20,40 40,30 T70,25 T100,20" fill="none" stroke="#6366F1" stroke-width="2" stroke-linecap="round"/></svg></div>
    </div>
</div>

<!-- Filters Row -->
<form id="filterForm" method="GET" action="{{ route('system_log') }}" class="mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s;">
    <div class="flex flex-wrap lg:flex-nowrap gap-4 items-center">
        
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            
            <!-- NEW DATE FILTER DROPDOWN -->
            <div class="relative mt-2 sm:mt-0">
                <label class="absolute -top-2 left-2 bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-gray-400 dark:text-slate-500 z-10">Time Range</label>
                <!-- Icon Kalender Custom di kiri -->
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 z-10">
                    <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <select name="date_range" onchange="document.getElementById('filterForm').submit()" class="relative appearance-none w-full bg-white dark:bg-slate-800 dark:text-slate-300 pl-9 pr-3 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-medium text-gray-700 dark:text-slate-200 outline-none hover:border-gray-300 dark:hover:border-slate-600 cursor-pointer z-0 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="Today" {{ $filterDate == 'Today' ? 'selected' : '' }}>Today</option>
                    <option value="Yesterday" {{ $filterDate == 'Yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="Last 7 Days" {{ $filterDate == 'Last 7 Days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="All Time" {{ $filterDate == 'All Time' ? 'selected' : '' }}>All Time</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 z-10">
                    <svg class="w-3 h-3 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Severity Filter -->
            <div class="relative mt-2 sm:mt-0">
                <label class="absolute -top-2 left-2 bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-gray-400 dark:text-slate-500 z-10">Severity</label>
                <select name="severity" onchange="document.getElementById('filterForm').submit()" class="relative appearance-none w-full bg-white dark:bg-slate-800 dark:text-slate-300 px-3 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-medium text-gray-700 dark:text-slate-200 outline-none hover:border-gray-300 dark:hover:border-slate-600 cursor-pointer z-0 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="All" {{ $filterSeverity == 'All' ? 'selected' : '' }}>All Levels</option>
                    <option value="Info" {{ $filterSeverity == 'Info' ? 'selected' : '' }}>Info</option>
                    <option value="Warning" {{ $filterSeverity == 'Warning' ? 'selected' : '' }}>Warning</option>
                    <option value="Critical" {{ $filterSeverity == 'Critical' ? 'selected' : '' }}>Critical</option>
                    <option value="Action" {{ $filterSeverity == 'Action' ? 'selected' : '' }}>Action</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 z-10">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Scenario Filter -->
            <div class="relative mt-2 sm:mt-0">
                <label class="absolute -top-2 left-2 bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-gray-400 dark:text-slate-500 z-10">Scenario</label>
                <select name="scenario" onchange="document.getElementById('filterForm').submit()" class="relative appearance-none w-full bg-white dark:bg-slate-800 dark:text-slate-300 px-3 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-medium text-gray-700 dark:text-slate-200 outline-none hover:border-gray-300 dark:hover:border-slate-600 cursor-pointer z-0 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="All Scenarios" {{ $filterScenario == 'All Scenarios' ? 'selected' : '' }}>All Scenarios</option>
                    @foreach($scenarios as $scen)
                        <option value="{{ $scen }}" {{ $filterScenario == $scen ? 'selected' : '' }}>{{ $scen }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 z-10">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <!-- Action Type Filter -->
            <div class="relative mt-2 sm:mt-0">
                <label class="absolute -top-2 left-2 bg-white dark:bg-slate-900 px-1 text-[10px] font-bold text-gray-400 dark:text-slate-500 z-10">Action Type</label>
                <select name="action_type" onchange="document.getElementById('filterForm').submit()" class="relative appearance-none w-full bg-white dark:bg-slate-800 dark:text-slate-300 px-3 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-medium text-gray-700 dark:text-slate-200 outline-none hover:border-gray-300 dark:hover:border-slate-600 cursor-pointer z-0 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="All Actions" {{ $filterAction == 'All Actions' ? 'selected' : '' }}>All Actions</option>
                    @foreach($actionTypes as $act)
                        <option value="{{ $act }}" {{ $filterAction == $act ? 'selected' : '' }}>{{ $act }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 z-10">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        <!-- Buttons Area -->
        <div class="flex items-center gap-2 w-full lg:w-auto mt-2 lg:mt-0 justify-end">
            <!-- Export Button -->
            <button type="submit" name="export" value="true" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-200 text-xs font-bold py-2.5 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Export CSV
            </button>
            <a href="{{ route('system_log') }}" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-[#005DCE] dark:text-indigo-300 text-xs font-bold py-2.5 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-slate-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg> Clear
            </a>
        </div>
    </div>
</form>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s;">
    
    <!-- Left Column (Chart & Table) -->
    <div class="xl:col-span-2 space-y-6">
        <!-- Timeline Chart -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm flex items-center gap-1">
                    Event Timeline ({{ $timelineTitle }}) <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </h3>
                <div class="flex items-center gap-4 text-[10px] font-bold text-gray-500 dark:text-slate-400">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Info</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-400"></span> Warning</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Critical</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#079844]"></span> Action</span>
                </div>
            </div>
            
            <div class="h-40 w-full relative">
                <div class="absolute left-[43%] top-0 bottom-6 border-l border-dashed border-indigo-600 z-10 flex flex-col items-center">
                    <span class="bg-indigo-600 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full absolute -top-3">10:24</span>
                </div>
                <canvas id="timelineChart"></canvas>
            </div>
        </div>

        <!-- Log Table -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50/50 dark:bg-slate-900 text-gray-500 dark:text-slate-400 font-bold border-b border-gray-100 dark:border-slate-700">
                        <tr>
                            <th class="px-6 py-4 flex items-center gap-1 cursor-pointer whitespace-nowrap">Time <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></th>
                            <th class="px-6 py-4 whitespace-nowrap">Event Type</th>
                            <th class="px-6 py-4">Severity</th>
                            <th class="px-6 py-4 whitespace-nowrap">System Condition</th>
                            <th class="px-6 py-4 whitespace-nowrap">Action Taken</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 font-medium">
                        @forelse($logs as $log)
                            @php
                                $sevBg = 'bg-blue-50'; $sevText = 'text-blue-500'; $icon = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                                if($log['severity'] == 'Critical') { $sevBg = 'bg-red-50'; $sevText = 'text-red-500'; $icon = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'; }
                                elseif($log['severity'] == 'Warning') { $sevBg = 'bg-orange-50'; $sevText = 'text-orange-500'; $icon = 'M13 10V3L4 14h7v7l9-11h-7z'; }
                                elseif($log['severity'] == 'Action') { $sevBg = 'bg-[#E6F4EA]'; $sevText = 'text-[#079844]'; $icon = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'; }
                            @endphp

                            <tr class="border-b border-gray-50 dark:border-slate-700 hover:bg-gray-50/50 dark:hover:bg-slate-900 transition-colors {{ $log['severity'] == 'Critical' ? 'bg-red-50/30 dark:bg-rose-500/10' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-slate-200">{{ $log['time'] }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-slate-100 flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-4 h-4 {{ $sevText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                                    {{ $log['type'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="{{ $sevBg }} {{ $sevText }} px-2.5 py-1 rounded-md text-[10px] font-bold">{{ $log['severity'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-slate-400 whitespace-nowrap">{{ $log['condition'] }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-slate-300 whitespace-nowrap">{{ $log['action'] }}</td>
                                <td class="px-6 py-4 flex items-center justify-between gap-4">
                                    <span class="flex items-center gap-1 {{ $log['status'] == 'Completed' ? 'text-[#079844]' : 'text-gray-400' }}">
                                        @if($log['status'] == 'Completed')
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                        {{ $log['status'] }}
                                    </span>
                                    <svg class="w-3.5 h-3.5 text-gray-300 cursor-pointer hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400 dark:text-slate-500">No events found matching your filters.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 flex flex-col md:flex-row items-center justify-between border-t border-gray-100 dark:border-slate-700 gap-4">
                <span class="text-[11px] text-gray-500 dark:text-slate-400 font-medium">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} events
                </span>
                
                @if ($logs->hasPages())
                <div class="flex items-center gap-1">
                    <a href="{{ $logs->previousPageUrl() }}" class="{{ $logs->onFirstPage() ? 'text-gray-300 pointer-events-none dark:text-slate-600' : 'text-gray-600 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-900' }} w-6 h-6 flex items-center justify-center rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    
                    @foreach(range(1, $logs->lastPage()) as $i)
                        @if($i == 1 || $i == $logs->lastPage() || abs($logs->currentPage() - $i) <= 1)
                            <a href="{{ $logs->url($i) }}" class="w-6 h-6 flex items-center justify-center rounded text-[10px] font-bold {{ $logs->currentPage() == $i ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-900' }}">{{ $i }}</a>
                        @elseif($i == 2 || $i == $logs->lastPage() - 1)
                            <span class="text-gray-400 text-[10px] mx-1">...</span>
                        @endif
                    @endforeach
                    
                    <a href="{{ $logs->nextPageUrl() }}" class="{{ !$logs->hasMorePages() ? 'text-gray-300 pointer-events-none dark:text-slate-600' : 'text-gray-600 hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-900' }} w-6 h-6 flex items-center justify-center rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column (Details) -->
    <div class="xl:col-span-1 space-y-6">
        
        <!-- Latest Critical Event -->
        <div class="bg-red-50/80 dark:bg-rose-900/20 border border-red-100 dark:border-rose-500/20 p-5 rounded-2xl shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-red-600 dark:text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="font-bold text-red-600 dark:text-rose-300 text-sm">Latest Critical Event</h3>
            </div>
            
            <div class="bg-white dark:bg-slate-900 rounded-xl p-5 shadow-sm border border-red-50 dark:border-rose-500/10">
                @if($latestCritical)
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-slate-100 text-sm">{{ $latestCritical['title'] }}</h4>
                        <span class="bg-red-50 dark:bg-rose-500/10 text-red-500 dark:text-rose-300 text-[9px] font-bold px-2 py-0.5 rounded-md">Critical</span>
                    </div>
                    <p class="text-[10px] text-gray-400 dark:text-slate-500 mb-4">{{ $latestCritical['time'] }}</p>
                    <p class="text-[11px] text-gray-600 dark:text-slate-300 mb-5 leading-relaxed">{{ $latestCritical['desc'] }}</p>
                    
                    <button class="w-full bg-[#FEF2F2] dark:bg-rose-900/20 hover:bg-red-100 dark:hover:bg-rose-800 text-red-600 dark:text-rose-200 text-[11px] font-bold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-1.5">
                        View Full Event Details 
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </button>
                @else
                    <div class="flex flex-col items-center justify-center py-4 text-center">
                        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-slate-100 text-sm mb-1">All Clear</h4>
                        <p class="text-[11px] text-gray-500 dark:text-slate-400">System is running smoothly.<br>No critical alerts recorded.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Technical Basis -->
        <div class="bg-slate-50 dark:bg-slate-900 border border-gray-100 dark:border-slate-700 p-5 rounded-2xl shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="font-bold text-gray-900 dark:text-slate-100 text-sm">Technical Basis</h3>
            </div>
            <p class="text-[11px] text-gray-600 dark:text-slate-400 mb-4 leading-relaxed">Event evaluated using HelioWatch <a href="#" class="text-indigo-600 dark:text-indigo-300 underline font-medium">Ramp Risk Algorithm v2.1</a></p>
            <ul class="text-[10px] text-gray-500 dark:text-slate-400 space-y-2 list-disc pl-4 mb-5 marker:text-gray-400">
                <li>IEC 62933-5-2:2018 (Energy Storage Systems)</li>
                <li>IEEE 1547-2018 (Interconnection Standard)</li>
                <li>NREL Microgrid Best Practices Guide</li>
            </ul>
            <a href="#" class="text-[11px] font-bold text-indigo-600 dark:text-indigo-300 flex items-center gap-1.5 hover:underline">
                View Methodology <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>

        <!-- Audit Trail -->
        <div class="bg-emerald-50/80 dark:bg-slate-900 border border-green-100 dark:border-emerald-500/20 p-5 rounded-2xl shadow-sm flex items-start gap-3">
            <div class="text-[#079844] dark:text-emerald-300 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 dark:text-slate-100 text-sm mb-1.5">Audit Trail</h3>
                <p class="text-[11px] text-gray-500 dark:text-slate-400 leading-relaxed">All times synchronized to NTP (UTC+7)<br>Data retention policy: 7 years</p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chartData = @json($chartData);
        
        const ctx = document.getElementById('timelineChart').getContext('2d');
        const labels = Array.from({length: 48}, (_, i) => {
            let hour = Math.floor(i / 2).toString().padStart(2, '0');
            let min = (i % 2 === 0) ? '00' : '30';
            return i % 8 === 0 ? `${hour}:${min}` : ''; 
        });

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Info', data: chartData.info, backgroundColor: '#60A5FA', barPercentage: 0.6 },
                    { label: 'Warning', data: chartData.warning, backgroundColor: '#FBBF24', barPercentage: 0.6 },
                    { label: 'Critical', data: chartData.critical, backgroundColor: '#EF4444', barPercentage: 0.6 },
                    { label: 'Action', data: chartData.action, backgroundColor: '#10B981', barPercentage: 0.6 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1f2937', padding: 10, cornerRadius: 8 } },
                scales: {
                    x: { stacked: true, grid: { display: false }, ticks: { color: '#9ca3af', font: {size: 9} } },
                    y: { stacked: true, beginAtZero: true, grid: { color: '#f3f4f6', drawBorder: false }, ticks: { color: '#9ca3af', font: {size: 9}, stepSize: 5 } }
                }
            }
        });
    });
</script>
@endpush