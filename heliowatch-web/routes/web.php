<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardApiController;

// 1. Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Alerts & Actions
Route::get('/alerts', [AlertController::class, 'index'])->name('alerts');

// 3. Scenario Simulation
Route::get('/simulation', [SimulationController::class, 'index'])->name('simulation');

// 4. System Log
Route::get('/system-log', [SystemLogController::class, 'index'])->name('system_log');

// 5. Settings
Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings');
Route::post('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
Route::post('/settings/reset', [App\Http\Controllers\SettingController::class, 'reset'])->name('settings.reset');

// Live data 
Route::get('/live-data', [DashboardApiController::class, 'getLiveData'])->name('api.live');