<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-300 ease-in-out w-64 bg-white dark:bg-slate-900 h-full shadow-[4px_0_24px_rgba(0,0,0,0.02)] dark:shadow-none dark:border-r dark:border-slate-800 rounded-r-3xl flex flex-col justify-between pt-10 pb-6 z-50 shrink-0">
    <div>
        <div class="px-6 mb-8 relative flex justify-center items-center">
            <!-- Logo -->
            <img src="{{ asset('img/logo-helio.png') }}" alt="HelioWatch Logo" class="w-40 mx-auto cursor-pointer transition-transform duration-300 hover:scale-105">
            
            <!-- Close Button (Mobile) -->
            <button onclick="toggleSidebar()" class="lg:hidden absolute right-6 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <nav class="flex flex-col gap-2 px-4 overflow-y-auto max-h-[60vh]">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#E4F5FE] text-[#005DCE] dark:bg-indigo-900/40 dark:text-indigo-400 font-semibold' : 'text-gray-500 hover:bg-[#E4F5FE] hover:text-[#005DCE] dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400 font-medium' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <!-- Alerts & Actions -->
            <a href="{{ route('alerts') }}" class="{{ request()->routeIs('alerts') ? 'bg-[#E4F5FE] text-[#005DCE] dark:bg-indigo-900/40 dark:text-indigo-400 font-semibold' : 'text-gray-500 hover:bg-[#E4F5FE] hover:text-[#005DCE] dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400 font-medium' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span>Alerts & Actions</span>
            </a>

            <!-- Scenario Simulation -->
            <a href="{{ route('simulation') }}" class="{{ request()->routeIs('simulation') ? 'bg-[#E4F5FE] text-[#005DCE] dark:bg-indigo-900/40 dark:text-indigo-400 font-semibold' : 'text-gray-500 hover:bg-[#E4F5FE] hover:text-[#005DCE] dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400 font-medium' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span>Scenario Simulation</span>
            </a>

            <!-- System Log -->
            <a href="{{ route('system_log') }}" class="{{ request()->routeIs('system_log') ? 'bg-[#E4F5FE] text-[#005DCE] dark:bg-indigo-900/40 dark:text-indigo-400 font-semibold' : 'text-gray-500 hover:bg-[#E4F5FE] hover:text-[#005DCE] dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400 font-medium' }} group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>System Log</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('settings') }}" class="{{ request()->routeIs('settings') ? 'bg-[#E4F5FE] text-[#005DCE] dark:bg-indigo-900/40 dark:text-indigo-400 font-semibold' : 'text-gray-500 hover:bg-[#E4F5FE] hover:text-[#005DCE] dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-indigo-400 font-medium' }} group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Settings</span>
            </a>
        </nav>
    </div>

    <!-- System Status Box -->
    <div class="px-6 mt-auto">
        <div class="bg-gray-50/90 dark:bg-slate-800/50 p-4 rounded-xl border border-gray-100 dark:border-slate-700/50 shadow-sm transition-colors duration-300">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-[#079844] animate-pulse shadow-[0_0_8px_rgba(7,152,68,0.6)]"></span>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">System Status</p>
            </div>
            <p class="text-sm font-bold text-[#079844] dark:text-emerald-400 ml-4">Operational</p>
            <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-2 ml-4">Last updated: <span id="sidebar-time">{{ \Carbon\Carbon::now($globalSettings['timezone'] ?? 'Asia/Jakarta')->format('h:i A') }}</span></p>
        </div>
    </div>
</aside>