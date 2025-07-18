<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportedReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('economic-groups', App\Http\Controllers\EconomicGroupController::class);
    Route::resource('flags', App\Http\Controllers\FlagController::class);
    Route::resource('units', App\Http\Controllers\UnitController::class);
    Route::resource('collaborators', App\Http\Controllers\CollaboratorController::class);
    Route::get('reports/collaborators', function () {
        return view('reports.collaborators.index');
    })->name('reports.collaborators');
    Route::get('reports/collaborators/export', [ReportController::class, 'exportCollaborators'])->name('reports.collaborators.export');
    Route::get('my-reports', [ExportedReportController::class, 'index'])->name('my-reports.index');
    Route::get('my-reports/{report}/download', [ExportedReportController::class, 'download'])->name('my-reports.download');
});


require __DIR__ . '/auth.php';
