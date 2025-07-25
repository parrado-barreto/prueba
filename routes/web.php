<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ClimaController;

Route::get('/', function () {
    return view('index');
});

// Clima
Route::get('/clima', [ClimaController::class, 'form'])->name('clima.form');
Route::get('/clima/buscar', [ClimaController::class, 'buscar'])->name('clima.buscar');

// Compra
Route::get('/compra', function () {
    return view('compra');
})->name('compra.form');
Route::post('/procesar-compra', [CompraController::class, 'procesar'])->name('procesar.compra');