@extends('layouts.app')
@section('title', 'Alerts & Actions')

@section('content')
    <!-- Header -->
    <header
        class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 opacity-0 animate-fade-in-down">
        <div>
            <h2
                class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-1 flex items-center gap-2 transition-colors">
                Alerts & Actions
                <svg class="w-6 h-6 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </h2>
            <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Operational alerts and recommended actions for
                safe, reliable microgrid operations.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 md:gap-4">
            <div
                class="bg-white dark:bg-slate-800 px-3 md:px-4 py-2 rounded-full shadow-sm text-xs md:text-sm font-medium border border-gray-100 dark:border-slate-700 flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
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

    <!-- Top KPI Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6 opacity-0 animate-fade-in-up"
        style="animation-delay: 0.1s;">
        <!-- Active Alerts -->
        <div
            class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-6 h-6 md:w-8 md:h-8 rounded-lg bg-red-50 dark:bg-rose-500/10 text-red-500 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Active Alerts</h3>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-red-500 dark:text-rose-400">
                    {{ $alertsData['kpi_summary']['active_alerts_count'] ?? 0 }}</p>
                <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-500 mt-1"><span
                        class="text-red-500 dark:text-rose-400 font-medium">{{ $alertsData['kpi_summary']['critical_count'] ?? 0 }}
                        Critical</span> • {{ $alertsData['kpi_summary']['high_count'] ?? 0 }} High</p>
            </div>
            <div class="w-full md:w-20 h-8 md:h-10 mt-2 md:mt-0">
                <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                    <path d="M0,40 C20,40 30,10 50,20 C70,30 80,10 100,15" fill="none" stroke="#EF4444" stroke-width="3"
                        stroke-linecap="round" />
                </svg>
            </div>
        </div>

        <!-- Critical Actions -->
        <div
            class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-6 h-6 md:w-8 md:h-8 rounded-lg bg-orange-50 dark:bg-amber-500/10 text-orange-500 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Critical Actions</h3>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100">
                    {{ $alertsData['kpi_summary']['critical_actions'] ?? 0 }}</p>
                <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-500 mt-1">Requires attention</p>
            </div>
            <div class="w-full md:w-20 h-8 md:h-10 mt-2 md:mt-0">
                <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                    <path d="M0,40 C20,30 30,45 50,20 C70,-5 80,30 100,20" fill="none" stroke="#F59E0B" stroke-width="3"
                        stroke-linecap="round" />
                </svg>
            </div>
        </div>

        <!-- Deferred Loads -->
        <div
            class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div
                        class="w-6 h-6 md:w-8 md:h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">Deferred Loads</h3>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100">
                    {{ $alertsData['kpi_summary']['deferred_loads_count'] ?? 0 }}</p>
                <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-500 mt-1">Total
                    {{ $alertsData['kpi_summary']['deferred_loads_kw'] ?? 0 }} kW</p>
            </div>
            <div class="w-full md:w-20 h-8 md:h-10 mt-2 md:mt-0">
                <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                    <path d="M0,40 C30,40 40,10 60,30 C70,40 80,10 100,10" fill="none" stroke="#6366F1"
                        stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>
        </div>

        <!-- System Status (Tailwind Bug Fixed with Style attributes) -->
        @php
            $sysColor = $alertsData['system_status']['color'] ?? 'green';
            $sysHex = $sysColor == 'green' ? '#079844' : ($sysColor == 'red' ? '#EF4444' : '#F59E0B');
            $bgStyle =
                $sysColor == 'green'
                    ? 'rgba(7, 152, 68, 0.1)'
                    : ($sysColor == 'red'
                        ? 'rgba(239, 68, 68, 0.1)'
                        : 'rgba(245, 158, 11, 0.1)');
        @endphp
        <div
            class="bg-white dark:bg-slate-800 p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg flex items-center justify-center shrink-0"
                        style="background-color: {{ $bgStyle }}; color: {{ $sysHex }}">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xs md:text-sm font-medium text-gray-600 dark:text-slate-400">System Status</h3>
                </div>
                <p class="text-xl md:text-2xl font-bold mt-1" style="color: {{ $sysHex }}">
                    {{ $alertsData['system_status']['status'] ?? 'Operational' }}</p>
                <p class="text-[10px] md:text-xs text-gray-500 dark:text-slate-500 mt-1">
                    {{ $alertsData['system_status']['detail'] ?? 'All systems normal' }}</p>
            </div>
            <div class="w-full md:w-20 h-8 md:h-10 mt-2 md:mt-0">
                <svg viewBox="0 0 100 50" class="w-full h-full" preserveAspectRatio="none">
                    <path d="M0,30 C20,30 30,40 50,20 C70,0 80,25 100,15" fill="none" stroke="{{ $sysHex }}"
                        stroke-width="3" stroke-linecap="round" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Middle Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s;">
        <!-- Active Alerts List -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col h-full transition-colors duration-300">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-bold text-gray-800 dark:text-slate-100">Active Alerts
                    ({{ count($alertsData['active_alerts'] ?? []) }})</h3>
                <a href="#"
                    class="text-xs font-medium text-gray-500 dark:text-slate-400 border border-gray-200 dark:border-slate-600 px-3 py-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">View
                    All</a>
            </div>
            <div class="space-y-3 flex-1 overflow-y-auto max-h-96 pr-2">
                @forelse($alertsData['active_alerts'] ?? [] as $alert)
                    @php
                        // Safe mapping warna
                        $colorHex =
                            $alert['color'] == 'red'
                                ? '#EF4444'
                                : ($alert['color'] == 'yellow'
                                    ? '#F59E0B'
                                    : '#6B7280');
                        $bgColor =
                            $alert['color'] == 'red'
                                ? 'rgba(239,68,68,0.1)'
                                : ($alert['color'] == 'yellow'
                                    ? 'rgba(245,158,11,0.1)'
                                    : 'rgba(107,114,128,0.1)');
                    @endphp
                    <div
                        class="flex gap-3 bg-white dark:bg-slate-900/50 p-3 rounded-xl border border-gray-100 dark:border-slate-700 shadow-sm transition-colors cursor-pointer relative overflow-hidden group hover:shadow-md">
                        <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-xl"
                            style="background-color: {{ $colorHex }}"></div>
                        <div class="mt-1 ml-1 group-hover:scale-110 transition-transform"
                            style="color: {{ $colorHex }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-slate-100">{{ $alert['type'] }}</h4>
                            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5 leading-tight">
                                {{ $alert['description'] }}</p>
                            <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-1">{{ $alert['time_ago'] }}</p>
                        </div>
                        <div class="flex flex-col items-end justify-between">
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md"
                                style="color: {{ $colorHex }}; background-color: {{ $bgColor }}">{{ $alert['severity'] }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-slate-400 text-center mt-10">No active alerts detected.</p>
                @endforelse
            </div>
        </div>

        <!-- Recommended Actions & Alternatives -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col h-full transition-colors duration-300">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-red-500 dark:text-rose-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122">
                    </path>
                </svg>
                <h3 class="font-bold text-gray-800 dark:text-slate-100">Recommended Primary Action</h3>
            </div>

            <div
                class="bg-red-50/40 dark:bg-rose-500/10 border border-red-100 dark:border-rose-500/20 rounded-xl p-5 mb-5 relative overflow-hidden">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-red-600 dark:text-rose-400 text-sm w-3/4">
                        {{ $alertsData['primary_action']['title'] ?? 'No Action Required' }}</h4>
                    <span
                        class="text-[10px] font-bold text-red-600 dark:text-rose-400 bg-red-100 dark:bg-rose-500/20 px-2 py-1 rounded-md">Critical</span>
                </div>
                <p class="text-xs text-gray-600 dark:text-slate-400 mb-4">Execute the action below now to maintain system
                    reliability.</p>

                <div
                    class="bg-white dark:bg-slate-800 rounded-lg p-4 shadow-sm border border-red-50 dark:border-rose-500/10">
                    <div class="flex gap-3">
                        <div class="mt-0.5 text-red-500 dark:text-rose-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="5" stroke="currentColor" stroke-width="3"
                                    fill="transparent" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-slate-200">
                                {{ $alertsData['primary_action']['description'] ?? '-' }}</h5>
                            <p class="text-[11px] text-gray-600 dark:text-slate-400 mt-2">Estimated effect:
                                {{ $alertsData['primary_action']['est_effect'] ?? '-' }}</p>
                            <div class="mt-4 flex justify-end">
                                <button
                                    class="bg-[#4F46E5] hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Execute Action
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="text-xs font-bold text-gray-600 dark:text-slate-400 mb-3">Alternative Actions</h4>
            <div class="space-y-3 mb-4">
                @foreach ($alertsData['alternative_actions'] ?? [] as $alt)
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-slate-700 pb-2">
                        <div class="flex gap-3 items-start">
                            <input type="radio" name="alt_action"
                                class="mt-1 w-4 h-4 text-indigo-600 border-gray-300 dark:border-slate-600 dark:bg-slate-800 focus:ring-indigo-500 cursor-pointer">
                            <div>
                                <h5 class="text-xs font-bold text-gray-800 dark:text-slate-300">{{ $alt['title'] }}</h5>
                                <p class="text-[10px] text-gray-500 dark:text-slate-500 mt-0.5">Est. effect:
                                    {{ $alt['est_effect'] }}</p>
                            </div>
                        </div>
                        <button
                            class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 px-3 py-1.5 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition-colors">Review</button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Operator Instructions -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col justify-between h-full transition-colors duration-300">
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-[#005DCE] dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    <h3 class="font-bold text-gray-800 dark:text-slate-100">Operator Instructions</h3>
                </div>
                <div class="space-y-4 flex-1">
                    @php
                        $instructions = $alertsData['operator_instructions'] ?? [];
                        $totalInst = count($instructions);
                        $completedInst = collect($instructions)->where('completed', true)->count();
                        $progressWidth = $totalInst > 0 ? ($completedInst / $totalInst) * 100 : 0;
                    @endphp
                    @forelse($instructions as $instruction)
                        <div class="flex gap-4 items-start relative">
                            <div
                                class="w-6 h-6 rounded-full bg-[#E4F5FE] dark:bg-indigo-900/30 text-[#005DCE] dark:text-indigo-400 flex items-center justify-center text-xs font-bold shrink-0 z-10">
                                {{ $loop->iteration }}</div>
                            @if (!$loop->last)
                                <div class="absolute top-6 bottom-[-20px] left-3 w-px bg-gray-100 dark:bg-slate-700 -z-0">
                                </div>
                            @endif
                            <div class="flex-1 pt-0.5 pb-2">
                                <h5 class="text-xs font-bold text-gray-800 dark:text-slate-200">{{ $instruction['step'] }}
                                </h5>
                                <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-0.5">
                                    {{ $instruction['detail'] }}</p>
                            </div>
                            <!-- Tambah class js-checkbox buat trigger JS nanti -->
                            <input type="checkbox"
                                class="js-op-checkbox mt-1 w-4 h-4 text-[#005DCE] border-gray-300 dark:border-slate-600 dark:bg-slate-800 rounded cursor-pointer"
                                {{ !empty($instruction['completed']) && $instruction['completed'] ? 'checked' : '' }}>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 dark:text-slate-400">No instructions available.</p>
                    @endforelse
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
                <span id="op-progress-text"
                    class="text-xs font-bold text-gray-500 dark:text-slate-400">{{ $completedInst }} /
                    {{ $totalInst }} completed</span>
                <div class="w-1/2 bg-gray-100 dark:bg-slate-700 rounded-full h-1.5 overflow-hidden">
                    <div id="op-progress-bar"
                        class="bg-[#005DCE] dark:bg-indigo-500 h-1.5 rounded-full transition-all duration-500"
                        style="width: {{ $progressWidth }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Horizon Table dkk -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 pb-8 opacity-0 animate-fade-in-up"
        style="animation-delay: 0.3s;">

        <!-- Affected Loads -->
        <div
            class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 flex flex-col h-full transform hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm">Affected Loads</h3>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-slate-400 mb-3">Top deferred or at-risk loads</p>

            <div class="space-y-3 mb-4 flex-1">
                @foreach ($alertsData['affected_loads'] ?? [] as $load)
                    @php
                        $lColor = $load['color'] ?? 'gray';
                        $lHex = $lColor == 'red' ? '#EF4444' : ($lColor == 'yellow' ? '#F59E0B' : '#6B7280');
                        $lBg =
                            $lColor == 'red'
                                ? 'rgba(239,68,68,0.1)'
                                : ($lColor == 'yellow'
                                    ? 'rgba(245,158,11,0.1)'
                                    : 'rgba(107,114,128,0.1)');
                    @endphp
                    <div
                        class="flex justify-between items-center text-xs border-b border-gray-50 dark:border-slate-700 pb-2">
                        <span class="text-gray-700 dark:text-slate-300 font-medium">{{ $load['name'] }}</span>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-900 dark:text-slate-100">{{ $load['power'] }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded w-14 text-center border"
                                style="color: {{ $lHex }}; background-color: {{ $lBg }}; border-color: {{ $lBg }}">{{ $load['status'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Decision Horizon Table -->
        <div
            class="xl:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transform hover:-translate-y-1 hover:shadow-md transition-all duration-300 overflow-hidden">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#005DCE] dark:text-indigo-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm">Decision Horizon (Next
                    {{ count($alertsData['decision_horizon'] ?? []) - 1 }} Hours)</h3>
            </div>
            <div class="w-full overflow-x-auto pb-2">
                <table class="w-full text-center text-[10px] font-medium min-w-[500px]">
                    <thead>
                        <tr class="text-gray-400 dark:text-slate-500 border-b border-gray-100 dark:border-slate-700">
                            <th class="text-left pb-2 font-medium"></th>
                            @foreach ($alertsData['decision_horizon'] ?? [] as $horizon)
                                <th class="pb-2">{{ $horizon['time'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 dark:text-slate-300">
                        <tr>
                            <td class="text-left py-3 font-bold text-[9px] text-gray-500 dark:text-slate-400">RAMP RISK
                            </td>
                            @foreach ($alertsData['decision_horizon'] ?? [] as $horizon)
                                <td class="py-3">
                                    <span class="px-1.5 py-0.5 rounded"
                                        style="background-color: {{ $horizon['ramp_risk'] >= 0.7 ? 'rgba(239,68,68,0.1)' : 'rgba(7,152,68,0.1)' }}; color: {{ $horizon['ramp_risk'] >= 0.7 ? '#EF4444' : '#079844' }}">
                                        {{ $horizon['ramp_risk'] }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-t border-gray-50 dark:border-slate-700/50">
                            <td class="text-left py-3 font-bold text-[9px] text-gray-500 dark:text-slate-400">RESERVE
                                MARGIN</td>
                            @foreach ($alertsData['decision_horizon'] ?? [] as $horizon)
                                <td class="py-3"><span
                                        class="{{ $horizon['reserve_margin'] < 20 ? 'text-red-500 dark:text-rose-400' : 'text-green-600 dark:text-emerald-400' }}">{{ $horizon['reserve_margin'] }}%</span>
                                </td>
                            @endforeach
                        </tr>
                        <tr class="border-t border-gray-50 dark:border-slate-700/50">
                            <td class="text-left py-3 font-bold text-[9px] text-gray-500 dark:text-slate-400">PV FORECAST
                                (kW)</td>
                            @foreach ($alertsData['decision_horizon'] ?? [] as $horizon)
                                <td class="py-3">{{ $horizon['pv_forecast'] }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Technical Basis & Community Impact -->
        <div class="space-y-6">
            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transition-colors duration-300">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm mb-3">Technical Basis</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-xs border-b border-gray-50 dark:border-slate-700 pb-1">
                        <span class="text-gray-600 dark:text-slate-400">Ramp Risk</span>
                        <span
                            class="font-bold text-red-500 dark:text-rose-400">{{ $alertsData['technical_basis']['ramp_risk'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between text-xs border-b border-gray-50 dark:border-slate-700 pb-1">
                        <span class="text-gray-600 dark:text-slate-400">Battery SoC</span>
                        <span
                            class="font-bold text-[#079844] dark:text-emerald-400">{{ $alertsData['technical_basis']['battery_soc'] ?? 0 }}%</span>
                    </div>
                    <div class="flex justify-between text-xs border-b border-gray-50 dark:border-slate-700 pb-1">
                        <span class="text-gray-600 dark:text-slate-400">Est. ENS</span>
                        <span class="font-bold dark:text-slate-200">{{ $alertsData['technical_basis']['est_ens'] ?? 0 }}
                            kWh</span>
                    </div>
                    <div class="flex justify-between text-xs border-b border-gray-50 dark:border-slate-700 pb-1">
                        <span class="text-gray-600 dark:text-slate-400">Net Margin</span>
                        <span
                            class="font-bold text-red-500 dark:text-rose-400">{{ $alertsData['technical_basis']['net_margin'] ?? 0 }}
                            kW</span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 transition-colors duration-300">
                <h3 class="font-bold text-gray-800 dark:text-slate-100 text-sm mb-3">Community Impact</h3>
                <div
                    class="bg-yellow-50 dark:bg-amber-500/10 rounded-xl p-2 mb-3 border border-yellow-100 dark:border-amber-500/20">
                    <p class="text-[10px] font-bold text-gray-800 dark:text-amber-400">
                        {{ $alertsData['community_impact']['title'] ?? 'Minimize impact' }}</p>
                </div>
                <h4 class="text-[11px] font-bold text-gray-800 dark:text-slate-200">
                    {{ $alertsData['community_impact']['subtitle'] ?? 'Services Protected' }}</h4>
                <p class="text-[10px] text-gray-500 dark:text-slate-400">
                    {{ $alertsData['community_impact']['description'] ?? 'Water and health center remain protected.' }}</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('.js-op-checkbox');
            const progressBar = document.getElementById('op-progress-bar');
            const progressText = document.getElementById('op-progress-text');

            if (checkboxes.length > 0) {
                checkboxes.forEach(box => {
                    box.addEventListener('change', function() {
                        let checkedCount = document.querySelectorAll('.js-op-checkbox:checked')
                            .length;
                        let totalCount = checkboxes.length;
                        let percentage = (checkedCount / totalCount) * 100;

                        progressBar.style.width = percentage + '%';
                        progressText.innerText = checkedCount + ' / ' + totalCount + ' completed';

                        // Opsional: Bikin animasi warna kalau penuh 100%
                        if (percentage === 100) {
                            progressBar.classList.replace('bg-[#005DCE]', 'bg-[#079844]');
                            progressBar.classList.replace('dark:bg-indigo-500',
                                'dark:bg-emerald-500');
                        } else {
                            progressBar.classList.replace('bg-[#079844]', 'bg-[#005DCE]');
                            progressBar.classList.replace('dark:bg-emerald-500',
                                'dark:bg-indigo-500');
                        }
                    });
                });
            }
        });
    </script>
@endpush
