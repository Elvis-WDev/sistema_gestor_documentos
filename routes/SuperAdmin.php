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
Route::get('usuarios', [UsuariosController::class, 'index'])->name('usuarios');

Route::get('crear-usuario', [UsuariosController::class, 'create'])->name('crear-usuario');

Route::post('store-usuario', [RegisteredUserController::class, 'store'])->name('store-usuario');

Route::get('editar-usuario/{id}', [UsuariosController::class, 'edit'])->name('editar-usuario');

Route::put('update-usuario', [RegisteredUserController::class, 'update'])->name('update-usuario');

Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');

Route::patch('/perfil', [UsuariosController::class, 'updateProfile'])->name('perfil.update');

//FACTURAS
Route::get('lista-facturas', [FacturasController::class, 'index'])->name('facturas');

Route::get('crear-factura', [FacturasController::class, 'create'])->name('crear-factura');

Route::get('editar-factura/{id_factura}', [FacturasController::class, 'edit'])->name('editar-factura');

//PAGOS
Route::get('lista-pagos', [PagosController::class, 'index'])->name('pagos');

Route::get('crear-pago', [PagosController::class, 'create'])->name('crear-pago');

Route::get('editar-pago/{id_pago}', [PagosController::class, 'edit'])->name('editar-pago');

//RETENCIONES
Route::get('lista-retenciones', [RetencionesController::class, 'index'])->name('retenciones');

Route::get('crear-retencion', [RetencionesController::class, 'create'])->name('crear-retencion');

Route::get('editar-retencion/{id}', [RetencionesController::class, 'edit'])->name('editar-retencion');

//SOLICITUD-AFILIADOS
Route::get('lista-solicitud-afiliados', [SolicitudAfiliadosController::class, 'index'])->name('solicitud-afiliados');

Route::get('crear-solicitud-afiliados', [SolicitudAfiliadosController::class, 'create'])->name('crear-solicitud-afiliados');

Route::get('editar-solicitud-afiliado/{id_solicitudAfiliados}', [SolicitudAfiliadosController::class, 'edit'])->name('editar-solicitud-afiliado');

//NOTAS-CREDITO
Route::get('lista-notas-credito', [NotasCreditoController::class, 'index'])->name('notas-credito');

Route::get('crear-notas-credito', [NotasCreditoController::class, 'create'])->name('crear-notas-credito');

Route::get('editar-nota-credito/{id}', [NotasCreditoController::class, 'edit'])->name('editar-nota-credito');

//CUSTOM-MODULE
Route::get('lista-custom-module', [ModulosPersonalizadoController::class, 'index'])->name('custom-module');

Route::get('crear-custom-module', [ModulosPersonalizadoController::class, 'create'])->name('crear-custom-module');

//CONFIGURACIONES-GENERALES
Route::get('lista-configuraciones', [ConfiguracionesGeneralesController::class, 'index'])->name('configuraciones');

Route::get('editar-configuracion/{id}', [ConfiguracionesGeneralesController::class, 'edit'])->name('editar-configuracion');
// });