<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/loginIn', [AuthController::class, 'sesionInicada'])->name('loginIn');
Route::post('/verify-email', [AuthController::class, 'verifyEmail']) -> name('verifyEmail');
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro_form');
Route::post('/registroAccion', [AuthController::class, 'registro'])->name('registro');

Route::get('/verify_email', function () {
    return view('verify');
})->name('verify_email');

Route::post('/verify_email', [AuthController::class, 'verificarCodigo'])->name('verify_email_post');



