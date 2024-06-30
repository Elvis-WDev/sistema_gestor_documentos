<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ConfiguracionesGeneralesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ModulosPersonalizadoController;
use App\Http\Controllers\NotasCreditoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetencionesController;
use App\Http\Controllers\SolicitudAfiliadosController;
use App\Http\Controllers\UsuariosController;
use App\Models\SolicitudAfiliados;
use Illuminate\Support\Facades\Route;



// Route::group(['middleware' => ['auth', 'verified']], function () {

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//USUARIOS
Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');

Route::patch('/perfil', [UsuariosController::class, 'updateProfile'])->name('perfil.update');

//FACTURAS
Route::get('lista-facturas', [FacturasController::class, 'index'])->name('facturas');

Route::get('crear-factura', [FacturasController::class, 'create'])->name('crear-factura');

//PAGOS
Route::get('lista-pagos', [PagosController::class, 'index'])->name('pagos');

//SOLICITUD-AFILIADOS
Route::get('lista-solicitud-afiliados', [SolicitudAfiliadosController::class, 'index'])->name('solicitud-afiliados');

Route::get('crear-solicitud-afiliados', [SolicitudAfiliadosController::class, 'create'])->name('crear-solicitud-afiliados');
// });