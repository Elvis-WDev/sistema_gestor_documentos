<?php

use App\DataTables\RolesDataTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\RegisteredUserController,
    ConfiguracionesGeneralesController,
    DashboardController,
    FacturasController,
    ModulosPersonalizadoController,
    NotasCreditoController,
    PagosController,
    ProfileController,
    RetencionesController,
    RolesController,
    SolicitudAfiliadosController,
    UsuariosController
};

require __DIR__ . '/auth.php';


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');

    Route::patch('/perfil', [UsuariosController::class, 'updateProfile'])->name('perfil.update');

    //CUSTOM-MODULE
    Route::get('lista-custom-module', [ModulosPersonalizadoController::class, 'index'])->name('custom-module');

    Route::get('crear-custom-module', [ModulosPersonalizadoController::class, 'create'])->name('crear-custom-module');

    //CONFIGURACIONES-GENERALES
    Route::get('lista-configuraciones', [ConfiguracionesGeneralesController::class, 'index'])->name('configuraciones');

    Route::get('editar-configuracion/{id}', [ConfiguracionesGeneralesController::class, 'edit'])->name('editar-configuracion');
});

//USUARIOS Y ROLES
Route::group(['middleware' => ['can:ver usuario']], function () {
    Route::get('usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('roles', [RolesController::class, 'index'])->name('roles');
});
Route::group(['middleware' => ['can:crear usuario']], function () {
    Route::get('crear-usuario', [UsuariosController::class, 'create'])->name('crear-usuario');

    Route::post('store-usuario', [RegisteredUserController::class, 'store'])->name('store-usuario');

    Route::get('crear-rol', [RolesController::class, 'create'])->name('crear-rol');

    Route::post('store-rol', [RolesController::class, 'store'])->name('store-rol');
});
Route::group(['middleware' => ['can:modificar usuario']], function () {
    Route::get('editar-usuario/{id}', [UsuariosController::class, 'edit'])->name('editar-usuario');

    Route::put('update-usuario', [RegisteredUserController::class, 'update'])->name('update-usuario');

    Route::get('editar-rol/{id}', [RolesController::class, 'edit'])->name('editar-rol');

    Route::put('update-rol', [RolesController::class, 'update'])->name('update-rol');
});

//FACTURAS
Route::group(['middleware' => ['can:ver facturas']], function () {
    Route::get('lista-facturas', [FacturasController::class, 'index'])->name('facturas');
});
Route::group(['middleware' => ['can:crear facturas']], function () {
    Route::get('crear-factura', [FacturasController::class, 'create'])->name('crear-factura');
});
Route::group(['middleware' => ['can:modificar facturas']], function () {
    Route::get('editar-factura/{id_factura}', [FacturasController::class, 'edit'])->name('editar-factura');
});

//PAGOS
Route::group(['middleware' => ['can:ver pagos']], function () {
    Route::get('lista-pagos', [PagosController::class, 'index'])->name('pagos');
});
Route::group(['middleware' => ['can:crear pagos']], function () {
    Route::get('crear-pago', [PagosController::class, 'create'])->name('crear-pago');
});
Route::group(['middleware' => ['can:modificar pagos']], function () {
    Route::get('editar-pago/{id_pago}', [PagosController::class, 'edit'])->name('editar-pago');
});

//NotasDeCredito
Route::group(['middleware' => ['can:ver NotasCredito']], function () {
    Route::get('lista-notas-credito', [NotasCreditoController::class, 'index'])->name('notas-credito');
});
Route::group(['middleware' => ['can:crear NotasCredito']], function () {
    Route::get('crear-notas-credito', [NotasCreditoController::class, 'create'])->name('crear-notas-credito');
});
Route::group(['middleware' => ['can:modificar NotasCredito']], function () {
    Route::get('editar-nota-credito/{id}', [NotasCreditoController::class, 'edit'])->name('editar-nota-credito');
});

//SolicitudAfiliado
Route::group(['middleware' => ['can:ver SolicitudAfiliado']], function () {
    Route::get('lista-solicitud-afiliados', [SolicitudAfiliadosController::class, 'index'])->name('solicitud-afiliados');
});
Route::group(['middleware' => ['can:crear SolicitudAfiliado']], function () {
    Route::get('crear-solicitud-afiliados', [SolicitudAfiliadosController::class, 'create'])->name('crear-solicitud-afiliados');
});
Route::group(['middleware' => ['can:modificar SolicitudAfiliado']], function () {
    Route::get('editar-solicitud-afiliado/{id_solicitudAfiliados}', [SolicitudAfiliadosController::class, 'edit'])->name('editar-solicitud-afiliado');
});

//RETENCIONES
Route::group(['middleware' => ['can:ver retenciones']], function () {
    Route::get('lista-retenciones', [RetencionesController::class, 'index'])->name('retenciones');
});
Route::group(['middleware' => ['can:crear retenciones']], function () {
    Route::get('crear-retencion', [RetencionesController::class, 'create'])->name('crear-retencion');
});
Route::group(['middleware' => ['can:modificar retenciones']], function () {
    Route::get('editar-retencion/{id}', [RetencionesController::class, 'edit'])->name('editar-retencion');
});


// Route::group(['middleware' => ['auth', 'verified']], function () {

//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     //USUARIOS
//     Route::get('usuarios', [UsuariosController::class, 'index'])->name('usuarios');

//     Route::get('crear-usuario', [UsuariosController::class, 'create'])->name('crear-usuario');

//     Route::post('store-usuario', [RegisteredUserController::class, 'store'])->name('store-usuario');

//     Route::get('editar-usuario/{id}', [UsuariosController::class, 'edit'])->name('editar-usuario');

//     Route::put('update-usuario', [RegisteredUserController::class, 'update'])->name('update-usuario');

//     Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');

//     Route::patch('/perfil', [UsuariosController::class, 'updateProfile'])->name('perfil.update');

//     //Roles
//     Route::get('roles', [RolesController::class, 'index'])->name('roles');

//     Route::get('crear-rol', [RolesController::class, 'create'])->name('crear-rol');

//     Route::post('store-rol', [RolesController::class, 'store'])->name('store-rol');

//     Route::get('editar-rol/{id}', [RolesController::class, 'edit'])->name('editar-rol');

//     Route::put('update-rol', [RolesController::class, 'update'])->name('update-rol');

//     //FACTURAS
//     Route::get('lista-facturas', [FacturasController::class, 'index'])->name('facturas');

//     Route::get('crear-factura', [FacturasController::class, 'create'])->name('crear-factura');

//     Route::get('editar-factura/{id_factura}', [FacturasController::class, 'edit'])->name('editar-factura');

//     //PAGOS
//     Route::get('lista-pagos', [PagosController::class, 'index'])->name('pagos');

//     Route::get('crear-pago', [PagosController::class, 'create'])->name('crear-pago');

//     Route::get('editar-pago/{id_pago}', [PagosController::class, 'edit'])->name('editar-pago');

//     //RETENCIONES
//     Route::get('lista-retenciones', [RetencionesController::class, 'index'])->name('retenciones');

//     Route::get('crear-retencion', [RetencionesController::class, 'create'])->name('crear-retencion');

//     Route::get('editar-retencion/{id}', [RetencionesController::class, 'edit'])->name('editar-retencion');

//     //SOLICITUD-AFILIADOS
//     Route::get('lista-solicitud-afiliados', [SolicitudAfiliadosController::class, 'index'])->name('solicitud-afiliados');

//     Route::get('crear-solicitud-afiliados', [SolicitudAfiliadosController::class, 'create'])->name('crear-solicitud-afiliados');

//     Route::get('editar-solicitud-afiliado/{id_solicitudAfiliados}', [SolicitudAfiliadosController::class, 'edit'])->name('editar-solicitud-afiliado');

//     //NOTAS-CREDITO
//     Route::get('lista-notas-credito', [NotasCreditoController::class, 'index'])->name('notas-credito');

//     Route::get('crear-notas-credito', [NotasCreditoController::class, 'create'])->name('crear-notas-credito');

//     Route::get('editar-nota-credito/{id}', [NotasCreditoController::class, 'edit'])->name('editar-nota-credito');

//     //CUSTOM-MODULE
//     Route::get('lista-custom-module', [ModulosPersonalizadoController::class, 'index'])->name('custom-module');

//     Route::get('crear-custom-module', [ModulosPersonalizadoController::class, 'create'])->name('crear-custom-module');

//     //CONFIGURACIONES-GENERALES
//     Route::get('lista-configuraciones', [ConfiguracionesGeneralesController::class, 'index'])->name('configuraciones');

//     Route::get('editar-configuracion/{id}', [ConfiguracionesGeneralesController::class, 'edit'])->name('editar-configuracion');
// });