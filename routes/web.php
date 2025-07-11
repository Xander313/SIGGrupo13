<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZonaSeguraController;
use App\Http\Controllers\PuntoEncuentroController;
use App\Http\Controllers\RiesgoController;
use App\Http\Controllers\UsuarioController;






Route::get('/', function () {
    return view('login');
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

Route::post('usuarios/zonas-seguras/create-report', [UsuarioController::class, 'generarReporte'])
     ->name('usuarios-zonas-seguras.reporte');


//RUTA PARA LA GENRACION DE REPORTE EN PDF DE ZONAS DE RiESGO ADMIN
Route::post('/zonas-riesgo/create-report', [RiesgoController::class, 'generarReporte'])
     ->name('zonas-riesgo.reporte');

//USUARIO
Route::post('usuarios/zonas-riesgo/create-report', [UsuarioController::class, 'generarReporteR'])
     ->name('usuarios-zonas-riesgo.reporte');



//RUTA PARA LA GENRACION DE REPORTE EN PDF DE PUNTOS DE ENCUENTRO












// Vista previa del reporte con mapa interactivo
Route::get('/zonas-seguras/vista-reporte', [ZonaSeguraController::class, 'vistaReporte'])
     ->name('zonas-seguras.vista-reporte');

     
//Vista previa del reporte con mapa interactivo Zonas de Riesgo
Route::get('/zonas-riesgo/vista-reporte', [RiesgoController::class, 'vistaReporte'])
     ->name('zonas-riesgo.vista-reporte');

//solo imagen de las zonas seguras
Route::get('/zonas-seguras/preview-mapa', [ZonaSeguraController::class, 'mostrarMapa']);
//solo imagen de las zonas de riesgo
Route::get('/zonas-riesgo/preview-mapa', [RiesgoController::class, 'mostrarMapa']);

     
// RUTA para la vista previa de los mapas de puntos de encuentro de los usuarios
Route::get('usuario/puntos-encuentro/vista-reporte', [UsuarioController::class, 'vistaReporteEncuentros'])
     ->name('usuario-puntos-encuentro.vista-reporte');

//RUTA FULLREST PARA ZONAS SEGURAS
Route::resource('/admin/zonas-seguras', ZonaSeguraController::class);







//RUTA para la vista previa de los mapas de zonas seguras de los usuarios
Route::get('usuario/zonas-seguras/vista-reporte', [UsuarioController::class, 'vistaReporte'])
     ->name('usuario-zonas-seguras.vista-reporte');

//RUTA para la vista previa de los mapas de zonas de riesgo de los usuarios
Route::get('usuario/zonas-riesgo/vista-riesgo', [UsuarioController::class, 'vistaReporteR'])
     ->name('usuario-zonas-riesgo.vista-riesgo');

// Agregar estas rutas dentro del grupo prefix('admin')
Route::get('puntos-encuentro/vista-reporte', [PuntoEncuentroController::class, 'vistaReporte'])
     ->name('admin.puntos-encuentro.vista-reporte');

Route::post('puntos-encuentro/generar-reporte', [PuntoEncuentroController::class, 'generarReporte'])
     ->name('admin.puntos-encuentro.generar-reporte');

     Route::post('usuarios/puntos-encuentro/generar-reporte', [UsuarioController::class, 'generarReporteEncuentros'])
     ->name('usuarios-puntos-encuentro.generar-reporte');

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



