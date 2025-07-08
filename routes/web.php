<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZonaSeguraController;
use App\Http\Controllers\PuntoEncuentroController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\UsuarioController;






Route::get('/', function () {
    return view('welcome');
});



// rutas para los usuarios

// En tus rutas (web.php):
Route::get('/user/inicio', [UsuarioController::class, 'inicio'])
    ->name('user.inicio');




Route::get('/login', [AuthController::class, 'iniciarSesion'])->name('login');


Route::post('/loginIn', [AuthController::class, 'sesionInicada'])->name('loginIn');

Route::post('/verify-email', [AuthController::class, 'verifyEmail']) -> name('verifyEmail');

Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro_form');

Route::post('/registroAccion', [AuthController::class, 'registro'])->name('registro');

Route::get('/verify_email', function () {
    return view('verify');
})->name('verify_email');

Route::post('/verify_email', [AuthController::class, 'verificarCodigo'])->name('verify_email_post');

//RUTA PARA LA GENRACION DE REPORTE EN PDF DE ZONAS SEGURAS
Route::post('/zonas-seguras/create-report', [ZonaSeguraController::class, 'generarReporte'])
     ->name('zonas-seguras.reporte');

// Vista previa del reporte con mapa interactivo
Route::get('/zonas-seguras/vista-reporte', [ZonaSeguraController::class, 'vistaReporte'])
     ->name('zonas-seguras.vista-reporte');


//solo imagen de las zonas seguras
Route::get('/zonas-seguras/preview-mapa', [ZonaSeguraController::class, 'mostrarMapa']);

     

//RUTA FULLREST PARA ZONAS SEGURAS
Route::resource('/admin/zonas-seguras', ZonaSeguraController::class);


//RUTA RESTFULL PARA USUARIOS
Route::get('usuario/zonas-seguras/vista-reporte', [UsuarioController::class, 'vistaReporte'])
     ->name('usuario-zonas-seguras.vista-reporte');





///rita para los puntos de encuentro
// RUTAS PARA PUNTOS DE ENCUENTRO (ADMIN)
Route::prefix('admin')->group(function() {
    Route::resource('puntos-encuentro', PuntoEncuentroController::class)
         ->names([
             'index' => 'admin.puntos-encuentro.index',
             'create' => 'admin.puntos-encuentro.create',
             'store' => 'admin.puntos-encuentro.store',
             'show' => 'admin.puntos-encuentro.show',
             'edit' => 'admin.puntos-encuentro.edit',
             'update' => 'admin.puntos-encuentro.update',
             'destroy' => 'admin.puntos-encuentro.destroy'
         ]);
});

////RUTAS LAS ZONAS DE RIESGO
Route::resource('/admin/ZonasRiesgo',RiesgoController::class);



