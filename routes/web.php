<?php

use App\Http\Controllers\CaptionController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpgradeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CaptionController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/generate-caption', [App\Http\Controllers\CaptionController::class, 'generate'])
        ->name('generate.caption');



    Route::get('/History', [HistoryController::class, 'index'])->name('history.show');

    Route::delete('/history/delete/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    Route::get('/upgrade', [UpgradeController::class, 'index'])->name('upgrade.show');


    Route::get('/checkout/{plan}', [PaymentController::class, 'checkout']);





});

Route::post('/paddle/webhook', [PaymentController::class, 'webhook']);

require __DIR__ . '/auth.php';















