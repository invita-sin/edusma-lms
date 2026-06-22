<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    $status = ['status' => 'ok', 'timestamp' => now()->toIso8601String()];

    try {
        DB::connection()->getPdo();
        $status['database'] = 'connected';
    } catch (\Exception $e) {
        $status['database'] = 'error';
        $status['status'] = 'degraded';
    }

    try {
        Cache::store('redis')->has('health_check');
        $status['cache'] = 'connected';
    } catch (\Exception $e) {
        $status['cache'] = 'unavailable';
        $status['status'] = 'degraded';
    }

    $httpCode = $status['status'] === 'ok' ? 200 : 503;
    return response()->json($status, $httpCode);
});

Route::middleware(['auth', 'role:super-admin,admin,teacher'])->prefix('reports')->group(function () {
    Route::get('/grades/pdf', [ReportController::class, 'downloadGradePdf'])->name('reports.grades.pdf');
    Route::get('/grades/excel', [ReportController::class, 'downloadGradeExcel'])->name('reports.grades.excel');
    Route::get('/attendances/pdf', [ReportController::class, 'downloadAttendancePdf'])->name('reports.attendances.pdf');
    Route::get('/attendances/excel', [ReportController::class, 'downloadAttendanceExcel'])->name('reports.attendances.excel');
    Route::get('/students/export', [ReportController::class, 'exportStudents'])->name('reports.students.export');
    Route::get('/students/{student}/report', [ReportController::class, 'exportStudentReport'])->name('reports.students.report');
});
