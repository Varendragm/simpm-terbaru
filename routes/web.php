<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InspectionReportController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MaintenanceHistoryController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PmScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('splash'))->name('splash');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/selamat-datang', [LoginController::class, 'welcome'])->name('welcome');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/performa', [PerformanceController::class, 'index'])->name('performance.index');
    Route::get('/performa/{machine}', [PerformanceController::class, 'show'])->name('performance.show');

    Route::middleware('role:supervisor')->group(function () {
        Route::get('/master/stasiun-mesin', [StationController::class, 'index'])->name('stations.index');
        Route::post('/master/stasiun', [StationController::class, 'store'])->name('stations.store');
        Route::put('/master/stasiun/{station}', [StationController::class, 'update'])->name('stations.update');
        Route::delete('/master/stasiun/{station}', [StationController::class, 'destroy'])->name('stations.destroy');
        Route::post('/master/mesin', [MachineController::class, 'store'])->name('machines.store');
        Route::put('/master/mesin/{machine}', [MachineController::class, 'update'])->name('machines.update');
        Route::delete('/master/mesin/{machine}', [MachineController::class, 'destroy'])->name('machines.destroy');
    });

    Route::get('/master/stasiun/{station}/mesin', [MachineController::class, 'byStation'])->name('machines.byStation');
    Route::get('/jadwal', [PmScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/jadwal/{schedule}', [PmScheduleController::class, 'show'])->name('schedules.show');

    Route::middleware('role:supervisor')->group(function () {
        Route::get('/jadwal-baru', [PmScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/jadwal', [PmScheduleController::class, 'store'])->name('schedules.store');
    });

    Route::middleware('role:teknisi')->group(function () {
        Route::get('/jadwal/{schedule}/laporan', [InspectionReportController::class, 'create'])->name('reports.create');
        Route::post('/jadwal/{schedule}/laporan', [InspectionReportController::class, 'store'])->name('reports.store');
    });

    Route::middleware('role:supervisor')->group(function () {
        Route::get('/validasi', [ValidationController::class, 'index'])->name('validation.index');
        Route::get('/validasi/{schedule}', [ValidationController::class, 'show'])->name('validation.show');
        Route::post('/validasi/{schedule}', [ValidationController::class, 'store'])->name('validation.store');
    });

    Route::get('/riwayat', [MaintenanceHistoryController::class, 'index'])->name('history.index');

    Route::middleware('role:supervisor,manajer')->group(function () {
        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    });
});
