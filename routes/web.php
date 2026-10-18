<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('events.index');
    }
    return redirect()->route('login');
});

// Rutas públicas para el formulario de registro de participantes
Route::get('/evento/{uuid}', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/evento/{uuid}', [ParticipantController::class, 'store'])->name('participants.store');

// Rutas protegidas para la administración
Route::middleware(['auth'])->group(function () {
    // Ruta puente para evitar que Laravel Breeze o el middleware fallen al buscar 'dashboard'
    Route::get('/dashboard', function () {
        return redirect()->route('events.index');
    })->name('dashboard');

    Route::resource('events', EventController::class);
    
    Route::get('/events/{event}/map', [EventController::class, 'mapCoordinates'])->name('events.map');
    Route::post('/events/{event}/map', [EventController::class, 'saveCoordinates'])->name('events.save_map');
    
    Route::get('/certificados/{event}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');
    Route::get('/certificados/{event}/bulk', [CertificateController::class, 'downloadBulk'])->name('certificates.bulk');
    Route::get('/certificados/{participant}/download', [CertificateController::class, 'downloadIndividual'])->name('certificates.individual');
    Route::post('/certificados/{event}/send', [CertificateController::class, 'sendBulkEmails'])->name('certificates.send_bulk');
    
    Route::delete('/participantes/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
});

require __DIR__.'/auth.php';