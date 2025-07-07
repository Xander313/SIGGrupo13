<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZonaSeguraController;
use App\Http\Controllers\PuntoEncuentroController;





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

//RUTA PARA LA GENRACION DE REPORTE EN PDF DE ZONAS SEGURAS
Route::get('/zonas-seguras/create-report', [ZonaSeguraController::class, 'generarReporte'])
     ->name('zonas-seguras.reporte');

// Vista previa del reporte con mapa interactivo
Route::get('/zonas-seguras/vista-reporte', [ZonaSeguraController::class, 'vistaReporte'])
     ->name('zonas-seguras.vista-reporte');


//solo imagen de las zonas seguras
Route::get('/zonas-seguras/preview-mapa', [ZonaSeguraController::class, 'mostrarMapa']);

     

//RUTA FULLREST PARA ZONAS SEGURAS
Route::resource('/admin/zonas-seguras', ZonaSeguraController::class);




///rita para los puntos de encuentro
Route::resource('puntos-encuentro', PuntoEncuentroController::class);
