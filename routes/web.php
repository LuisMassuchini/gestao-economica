<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

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
    Route::get('reports/collaborators', [ReportController::class, 'collaborators'])->name('reports.collaborators');
    Route::get('reports/collaborators/export', [ReportController::class, 'exportCollaborators'])->name('reports.collaborators.export');
});


require __DIR__ . '/auth.php';
