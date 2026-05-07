<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

@extends('layouts.app')
@section('title', 'Settings')

@section('content')
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <header
            class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4 opacity-0 animate-fade-in-down">
            <div>
                <h2
                    class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-slate-100 mb-1 flex items-center gap-2 transition-colors">
                    Settings
                    <svg class="w-6 h-6 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </h2>
                <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400">Configure your microgrid, alerts, and
                    operational preferences.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 md:gap-4">
                <div
                    class="bg-white dark:bg-slate-800 px-3 md:px-4 py-2 rounded-full shadow-sm text-xs md:text-sm font-medium border border-gray-100 dark:border-slate-700 flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span id="current-time"
                        class="dark:text-slate-300">{{ \Carbon\Carbon::now($globalSettings['timezone'] ?? 'Asia/Jakarta')->translatedFormat('d M Y • H:i') }}
                        WIB</span>
                </div>

                <div
                    class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 shadow-sm text-sm font-medium border border-gray-100 dark:border-slate-700 text-gray-700 dark:text-slate-300 transition-colors">
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

        <!-- Session Messages -->
        <div id="alert-messages-container" class="space-y-4 mb-6">
            @if (session('success'))
                <div
                    class="alert-message rounded-3xl border border-emerald-100 dark:border-emerald-900/50 bg-emerald-50 dark:bg-emerald-900/20 p-4 text-sm text-emerald-900 dark:text-emerald-300 flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="alert-message rounded-3xl border border-rose-100 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-900/20 p-4 text-sm text-rose-900 dark:text-rose-300 flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="alert-message rounded-3xl border border-rose-100 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-900/20 p-4 text-sm text-rose-900 dark:text-rose-300 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <span class="font-semibold">Validation Errors</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Microgrid Profile -->
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-gray-50 dark:border-slate-700 h-full transition-colors">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="bg-indigo-50 dark:bg-indigo-900/20 p-2 rounded-xl text-indigo-600 dark:text-indigo-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Site Location</h3>
                                <p class="text-[10px] text-gray-400 dark:text-slate-400">Pinpoint your microgrid
                                    coordinates.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Custom Site Name -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-1 ml-1 uppercase">Custom
                                    Site Name</label>
                                <input type="text" name="site_name"
                                    value="{{ old('site_name', $settings['site_name'] ?? 'Island Microgrid 1') }}"
                                    placeholder="e.g. Fasilitas Riset IPB"
                                    class="w-full rounded-xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 px-4 py-2.5 text-sm text-gray-900 dark:text-slate-100 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-indigo-300 transition-all">
                            </div>

                            <!-- Map -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-1 ml-1 uppercase">Coordinate
                                    Pinner</label>
                                <div id="map"
                                    class="w-full h-48 rounded-xl border border-gray-200 dark:border-slate-700 z-0 relative mb-2">
                                </div>

                                <div class="flex gap-2">
                                    <div class="flex gap-2">
                                        <div class="flex-1 relative">
                                            <span class="absolute left-3 top-2.5 text-xs text-gray-400">Lat:</span>
                                            <input type="number" step="any" name="site_latitude" id="input-lat"
                                                value="{{ old('site_latitude', $settings['site_latitude'] ?? '-6.5569') }}"
                                                class="w-full rounded-xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 pl-10 pr-3 py-2 text-xs font-mono text-gray-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder-gray-400">
                                        </div>
                                        <div class="flex-1 relative">
                                            <span class="absolute left-3 top-2.5 text-xs text-gray-400">Lng:</span>
                                            <input type="number" step="any" name="site_longitude" id="input-lng"
                                                value="{{ old('site_longitude', $settings['site_longitude'] ?? '106.7238') }}"
                                                class="w-full rounded-xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 pl-10 pr-3 py-2 text-xs font-mono text-gray-700 dark:text-slate-300 outline-none focus:ring-2 focus:ring-indigo-500 transition-all placeholder-gray-400">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operator -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-1 ml-1 uppercase">Operator</label>
                                <input type="text" name="operator_name"
                                    value="{{ old('operator_name', $settings['operator_name'] ?? '') }}"
                                    class="w-full rounded-xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 px-4 py-2.5 text-sm text-gray-900 dark:text-slate-100 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/30 transition-all">
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-1 ml-1 uppercase">Timezone</label>
                                <div class="relative">
                                    <select name="timezone" id="timezone-select"
                                        class="appearance-none w-full rounded-xl bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 px-4 py-2.5 pr-10 text-sm text-gray-900 dark:text-slate-100 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/30 transition-all cursor-pointer">

                                        @php
                                            $savedTz = old('timezone', $settings['timezone'] ?? 'Asia/Jakarta');
                                            $defaultTz = $timezones ?? [
                                                'Asia/Jakarta' => 'WIB (UTC+7) - Asia/Jakarta',
                                                'Asia/Makassar' => 'WITA (UTC+8) - Asia/Makassar',
                                                'Asia/Jayapura' => 'WIT (UTC+9) - Asia/Jayapura',
                                            ];
                                        @endphp

                                        @if (!array_key_exists($savedTz, $defaultTz))
                                            <option value="{{ $savedTz }}" selected>Auto Detected -
                                                {{ $savedTz }}</option>
                                        @endif

                                        @foreach ($defaultTz as $key => $label)
                                            <option value="{{ $key }}" {{ $savedTz == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 dark:text-slate-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Thresholds -->
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-gray-50 dark:border-slate-700 h-full flex flex-col transition-colors">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-rose-50 dark:bg-rose-900/20 p-2 rounded-xl text-rose-500 dark:text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Alert Thresholds</h3>
                                <p class="text-[10px] text-gray-400 dark:text-slate-400">Set boundary conditions for
                                    warnings.</p>
                            </div>
                        </div>

                        <div class="space-y-5 flex-1">
                            <div class="flex items-center justify-between gap-4 group">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-slate-300 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">Ramp
                                    Risk (60 min)</span>
                                <div class="flex items-center justify-end gap-2 w-32">
                                    <input type="number" name="ramp_risk_threshold" step="0.01"
                                        value="{{ old('ramp_risk_threshold', $settings['ramp_risk_threshold'] ?? '0.70') }}"
                                        class="w-20 text-right bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl px-3 py-2 text-sm font-bold text-rose-600 dark:text-rose-400 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-rose-300 dark:focus:border-rose-500 focus:ring-2 focus:ring-rose-100 dark:focus:ring-rose-500/30 transition-all" />
                                    <span class="text-xs font-bold text-transparent select-none w-8 text-left">kWh</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 group">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-slate-300 group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors">Battery
                                    SoC Warning</span>
                                <div class="flex items-center justify-end gap-2 w-32">
                                    <input type="number" name="soc_warning_threshold" step="1"
                                        value="{{ old('soc_warning_threshold', $settings['soc_warning_threshold'] ?? '30') }}"
                                        class="w-20 text-right bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl px-3 py-2 text-sm font-bold text-orange-500 dark:text-orange-400 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-orange-300 dark:focus:border-orange-500 focus:ring-2 focus:ring-orange-100 dark:focus:ring-orange-500/30 transition-all" />
                                    <span
                                        class="text-xs font-bold text-gray-400 dark:text-slate-500 w-8 text-left">%</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 group">
                                <span
                                    class="text-xs font-semibold text-gray-600 dark:text-slate-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">ENS
                                    Threshold (Today)</span>
                                <div class="flex items-center justify-end gap-2 w-32">
                                    <input type="number" name="ens_threshold" step="0.1"
                                        value="{{ old('ens_threshold', $settings['ens_threshold'] ?? '2.00') }}"
                                        class="w-20 text-right bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl px-3 py-2 text-sm font-bold text-amber-600 dark:text-amber-400 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-amber-300 dark:focus:border-amber-500 focus:ring-2 focus:ring-amber-100 dark:focus:ring-amber-500/30 transition-all" />
                                    <span
                                        class="text-xs font-bold text-gray-400 dark:text-slate-500 w-8 text-left">kWh</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 p-3 bg-indigo-50/50 dark:bg-slate-900 border border-indigo-100 dark:border-slate-700 rounded-2xl flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-400 dark:text-indigo-300 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z">
                                </path>
                            </svg>
                            <p class="text-[10px] text-indigo-600/80 dark:text-indigo-400 leading-tight">Alerts are
                                triggered when values cross the thresholds.</p>
                        </div>
                    </div>
                </div>

                <!-- Load Priority Setup -->
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-slate-800 p-6 h-full flex flex-col rounded-[2rem] shadow-sm border border-gray-50 dark:border-slate-700 transition-colors">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="bg-violet-50 dark:bg-violet-900/20 p-2 rounded-xl text-violet-600 dark:text-violet-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Load Priority Setup</h3>
                                <p class="text-[10px] text-gray-400 dark:text-slate-400">Define order for dispatch
                                    decisions.</p>
                            </div>
                        </div>

                        <div class="space-y-3 flex-1" id="drag-container">
                            <div draggable="true" data-key="critical"
                                class="group flex items-center justify-between p-3 border border-gray-100 dark:border-slate-700 rounded-2xl hover:border-indigo-200 dark:hover:border-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all cursor-grab active:cursor-grabbing">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="text-gray-300 dark:text-slate-600 group-hover:text-gray-400 dark:group-hover:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <div
                                        class="bg-rose-50 dark:bg-rose-900/20 p-1.5 rounded-lg text-rose-500 dark:text-rose-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 dark:text-slate-100 leading-none">
                                            Critical Loads</p>
                                        <p class="text-[9px] text-gray-400 dark:text-slate-400">Always on</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="load_priority_critical"
                                        value="{{ old('load_priority_critical', $settings['load_priority_critical'] ?? '1') }}">
                                    <span
                                        class="priority-badge text-[10px] font-bold text-rose-500 dark:text-rose-400 px-2 py-0.5 bg-rose-50 dark:bg-rose-900/20 rounded-md">Priority
                                        1</span>
                                </div>
                            </div>

                            <div draggable="true" data-key="flexible"
                                class="group flex items-center justify-between p-3 border border-gray-100 dark:border-slate-700 rounded-2xl hover:border-indigo-200 dark:hover:border-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all cursor-grab active:cursor-grabbing">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="text-gray-300 dark:text-slate-600 group-hover:text-gray-400 dark:group-hover:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <div
                                        class="bg-amber-50 dark:bg-amber-900/20 p-1.5 rounded-lg text-amber-500 dark:text-amber-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 dark:text-slate-100 leading-none">
                                            Flexible Loads</p>
                                        <p class="text-[9px] text-gray-400 dark:text-slate-400">Shiftable / Deferrable</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="load_priority_flexible"
                                        value="{{ old('load_priority_flexible', $settings['load_priority_flexible'] ?? '2') }}">
                                    <span
                                        class="priority-badge text-[10px] font-bold text-amber-500 dark:text-amber-400 px-2 py-0.5 bg-amber-50 dark:bg-amber-900/20 rounded-md">Priority
                                        2</span>
                                </div>
                            </div>

                            <div draggable="true" data-key="nonessential"
                                class="group flex items-center justify-between p-3 border border-gray-100 dark:border-slate-700 rounded-2xl hover:border-indigo-200 dark:hover:border-indigo-500 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all cursor-grab active:cursor-grabbing">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="text-gray-300 dark:text-slate-600 group-hover:text-gray-400 dark:group-hover:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <div
                                        class="bg-emerald-50 dark:bg-emerald-900/20 p-1.5 rounded-lg text-emerald-500 dark:text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900 dark:text-slate-100 leading-none">
                                            Non-Essential Loads</p>
                                        <p class="text-[9px] text-gray-400 dark:text-slate-400">May be shed</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="load_priority_nonessential"
                                        value="{{ old('load_priority_nonessential', $settings['load_priority_nonessential'] ?? '3') }}">
                                    <span
                                        class="priority-badge text-[10px] font-bold text-emerald-500 dark:text-emerald-400 px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-md">Priority
                                        3</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 p-3 bg-indigo-50/50 dark:bg-slate-900 border border-indigo-100 dark:border-slate-700 rounded-2xl flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-400 dark:text-indigo-300 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z">
                                </path>
                            </svg>
                            <p class="text-[10px] text-indigo-600/80 dark:text-indigo-400 leading-tight">Drag to reorder
                                priority. Higher priority loads are served first.</p>
                        </div>
                    </div>
                </div>

                <!-- Interface Preference -->
                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-gray-50 dark:border-slate-700 transition-colors">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="bg-indigo-50 dark:bg-indigo-900/20 p-2 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h10M4 18h7M10 6v4M14 14v6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Interface Preference</h3>
                            <p class="text-[10px] text-gray-400 dark:text-slate-400">Customize how the application looks.
                            </p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-2 uppercase">Refresh
                                Interval</label>
                            <div class="relative">
                                <select name="refresh_interval"
                                    class="appearance-none w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 px-4 py-3 pr-10 text-sm text-gray-900 dark:text-slate-100 outline-none focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-indigo-100 dark:focus:ring-indigo-500/30 cursor-pointer transition-all">
                                    <option value="15"
                                        {{ old('refresh_interval', $settings['refresh_interval'] ?? '30') == '15' ? 'selected' : '' }}>
                                        15 seconds</option>
                                    <option value="30"
                                        {{ old('refresh_interval', $settings['refresh_interval'] ?? '30') == '30' ? 'selected' : '' }}>
                                        30 seconds</option>
                                    <option value="60"
                                        {{ old('refresh_interval', $settings['refresh_interval'] ?? '30') == '60' ? 'selected' : '' }}>
                                        60 seconds</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 dark:text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-gray-400 dark:text-slate-400 mb-2 uppercase">Theme</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label
                                    class="cursor-pointer rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 transition hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-500/10">
                                    <input type="radio" name="theme" value="light" class="sr-only peer"
                                        {{ old('theme', $settings['theme'] ?? 'light') == 'light' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-slate-100 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 dark:peer-checked:border-indigo-500 dark:peer-checked:bg-indigo-500 peer-checked:text-white shadow-sm peer-checked:shadow-md transition-all">Light</span>
                                </label>
                                <label
                                    class="cursor-pointer rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 transition hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-500/10">
                                    <input type="radio" name="theme" value="dark" class="sr-only peer"
                                        {{ old('theme', $settings['theme'] ?? 'light') == 'dark' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-slate-100 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 dark:peer-checked:border-indigo-500 dark:peer-checked:bg-indigo-500 peer-checked:text-white shadow-sm peer-checked:shadow-md transition-all">Dark</span>
                                </label>
                                <label
                                    class="cursor-pointer rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900 transition hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-500/10">
                                    <input type="radio" name="theme" value="system" class="sr-only peer"
                                        {{ old('theme', $settings['theme'] ?? 'light') == 'system' ? 'checked' : '' }}>
                                    <span
                                        class="block rounded-2xl px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-slate-100 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 dark:peer-checked:border-indigo-500 dark:peer-checked:bg-indigo-500 peer-checked:text-white shadow-sm peer-checked:shadow-md transition-all">System</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-gray-50 dark:border-slate-700 transition-colors">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-green-50 dark:bg-green-900/20 p-2 rounded-xl text-green-600 dark:text-green-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Notification Settings</h3>
                            <p class="text-[10px] text-gray-400 dark:text-slate-400">Choose how you want to receive alerts.
                            </p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div
                            class="flex items-center justify-between rounded-2xl border border-gray-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4 transition-colors">
                            <div class="flex items-center gap-3">
                                <div
                                    class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-2xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8H3v8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-100">Email Notifications
                                    </p>
                                    <p class="text-[10px] text-gray-500 dark:text-slate-400">Receive alerts via email.</p>
                                </div>
                            </div>
                            <input type="hidden" name="email_notifications" value="0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" value="1" class="sr-only peer"
                                    {{ old('email_notifications', $settings['email_notifications'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div
                                    class="w-12 h-6 bg-slate-200 dark:bg-slate-700 peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 rounded-full transition-colors">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-6 transition-transform">
                                </div>
                            </label>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-2xl border border-gray-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4 transition-colors">
                            <div class="flex items-center gap-3">
                                <div
                                    class="bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 p-2 rounded-2xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h7m-1 8l-4-4H5V7h14v9h-2l-4 4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-100">SMS Notifications
                                    </p>
                                    <p class="text-[10px] text-gray-500 dark:text-slate-400">Receive critical alerts via
                                        SMS.</p>
                                </div>
                            </div>
                            <input type="hidden" name="sms_notifications" value="0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="sms_notifications" value="1" class="sr-only peer"
                                    {{ old('sms_notifications', $settings['sms_notifications'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div
                                    class="w-12 h-6 bg-slate-200 dark:bg-slate-700 peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 rounded-full transition-colors">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-6 transition-transform">
                                </div>
                            </label>
                        </div>

                        <div
                            class="flex items-center justify-between rounded-2xl border border-gray-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-4 transition-colors">
                            <div class="flex items-center gap-3">
                                <div
                                    class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 p-2 rounded-2xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5.882L7.764 8.118H4.5A1.5 1.5 0 003 9.618v4.764A1.5 1.5 0 004.5 16.5h3.264L11 18.118V5.882z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.536 8.464a5 5 0 010 7.072" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 5.636a9 9 0 010 12.728" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-100">Alert Sounds</p>
                                    <p class="text-[10px] text-gray-500 dark:text-slate-400">Play a sound for new alerts.
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" name="alert_sounds" value="0">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="alert_sounds" value="1" class="sr-only peer"
                                    {{ old('alert_sounds', $settings['alert_sounds'] ?? '1') === '1' ? 'checked' : '' }}>
                                <div
                                    class="w-12 h-6 bg-slate-200 dark:bg-slate-700 peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 rounded-full transition-colors">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-6 transition-transform">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Footer Banner -->
                <div
                    class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 p-6 rounded-[2rem] border border-white/80 dark:border-slate-700 shadow-sm flex flex-col items-center justify-center text-center transition-colors">
                    <div class="bg-white dark:bg-slate-900 p-4 rounded-3xl shadow-sm mb-3">
                        <svg class="w-10 h-10 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-800 dark:text-slate-100">Your microgrid is in good hands.</p>
                    <p class="text-[10px] text-gray-500 dark:text-slate-400 mt-2">These settings help us optimize
                        performance, ensure reliability, and keep your community powered sustainably.</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch justify-end gap-3 mt-6">
                <button type="submit" formaction="{{ route('settings.reset') }}" formmethod="POST"
                    class="w-full sm:w-auto rounded-2xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-500 dark:text-slate-300 px-6 py-3 text-sm font-bold transition hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-gray-700 dark:hover:text-slate-100">
                    Reset to Defaults
                </button>
                <button type="submit"
                    class="w-full sm:w-auto rounded-2xl bg-indigo-600 px-10 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 hover:shadow-indigo-300 transform hover:-translate-y-0.5 transition-all">
                    Save Settings
                </button>
            </div>
        </form>

    </div>

    <!-- Drag Logic & Auto-hide Alert Script -->
    <script>
        // Auto-hide Alerts Function
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-message');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500); // Remove from DOM after fade out
                });
            }, 4000);
        });

        // Drag Container Logic
        const container = document.getElementById('drag-container');
        let dragItem = null;

        container.addEventListener('dragstart', (e) => {
            dragItem = e.target;
            dragItem.classList.add('dragging');
            setTimeout(() => e.target.style.opacity = "0.5", 0);
        });

        container.addEventListener('dragend', (e) => {
            setTimeout(() => e.target.style.opacity = "1", 0);
            if (dragItem) {
                dragItem.classList.remove('dragging');
            }
            dragItem = null;
            updatePriorities();
        });

        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(container, e.clientY);
            if (afterElement == null) {
                container.appendChild(dragItem);
            } else {
                container.insertBefore(dragItem, afterElement);
            }
            updatePriorities();
        });

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('[draggable="true"]:not(.dragging)')];
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

        function updatePriorities() {
            const items = container.querySelectorAll('[draggable="true"]');
            items.forEach((item, index) => {
                const badge = item.querySelector('span.priority-badge');
                const priorityInput = item.querySelector('input[type="hidden"]');
                if (badge) {
                    badge.textContent = `Priority ${index + 1}`;
                }
                if (priorityInput) {
                    priorityInput.value = index + 1;
                }
            });
        }

        function reorderInitialPriorities() {
            const items = Array.from(container.querySelectorAll('[draggable="true"]'));
            items.sort((a, b) => {
                const aValue = Number(a.querySelector('input[type="hidden"]').value || 0);
                const bValue = Number(b.querySelector('input[type="hidden"]').value || 0);
                return aValue - bValue;
            });
            items.forEach(item => container.appendChild(item));
            updatePriorities();
        }

        reorderInitialPriorities();
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen input
            var latInput = document.getElementById('input-lat');
            var lngInput = document.getElementById('input-lng');

            // Set koordinat awal dari value input
            var startLat = parseFloat(latInput.value) || -6.5569;
            var startLng = parseFloat(lngInput.value) || 106.7238;

            // Inisialisasi Peta
            var map = L.map('map').setView([startLat, startLng], 13);

            // Load gambar peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Tambahkan Pin/Marker yang bisa digeser
            var marker = L.marker([startLat, startLng], {
                draggable: true
            }).addTo(map);

            // Event 1: Kalau Pin digeser, angka di input otomatis berubah
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                latInput.value = position.lat.toFixed(6);
                lngInput.value = position.lng.toFixed(6);
            });

            // Event 2: Kalau angka di input diketik manual, Pin otomatis pindah
            function updateMapFromInput() {
                var newLat = parseFloat(latInput.value);
                var newLng = parseFloat(lngInput.value);
                if (!isNaN(newLat) && !isNaN(newLng)) {
                    var newPos = new L.LatLng(newLat, newLng);
                    marker.setLatLng(newPos);
                    map.flyTo(newPos, 13);
                }
            }

            latInput.addEventListener('input', updateMapFromInput);
            lngInput.addEventListener('input', updateMapFromInput);
        });
    </script>
@endsection
