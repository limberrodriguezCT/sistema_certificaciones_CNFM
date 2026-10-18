<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/evento/{uuid}', [ParticipantController::class, 'create'])->name('participants.create');
Route::post('/evento/{uuid}', [ParticipantController::class, 'store'])->name('participants.store');

Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class)->except(['edit', 'update', 'destroy']);
    
    Route::get('/events/{event}/map', [EventController::class, 'mapCoordinates'])->name('events.map');
    Route::post('/events/{event}/map', [EventController::class, 'saveCoordinates'])->name('events.save_map');
    
    Route::get('/certificados/{event}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');
    Route::get('/certificados/{event}/bulk', [CertificateController::class, 'downloadBulk'])->name('certificates.bulk');
    Route::get('/certificados/{participant}/download', [CertificateController::class, 'downloadIndividual'])->name('certificates.individual');
    Route::post('/certificados/{event}/send', [CertificateController::class, 'sendBulkEmails'])->name('certificates.send_bulk');
});

require __DIR__.'/auth.php';