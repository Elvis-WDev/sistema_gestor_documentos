<?php

use App\DataTables\RolesDataTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AbonosController,
    ArchivosController,
    Auth\RegisteredUserController,
    ConfiguracionesGeneralesController,
    CuentasPorCobrarController,
    DashboardController,
    EstablecimientosController,
    FacturasController,
    ModulosPersonalizadoController,
    NotasCreditoController,
    PagosController,
    ProfileController,
    PuntosEmisionController,
    ReportesController,
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

Route::group(['middleware' => ['can:eliminar usuario']], function () {
    Route::delete('eliminar-usuario/{id}', [UsuariosController::class, 'destroy'])->name('destroy-usuario');
    Route::delete('eliminar-rol/{id}', [RolesController::class, 'destroy'])->name('destroy-rol');
});

//FACTURAS
Route::group(['middleware' => ['can:ver facturas']], function () {
    Route::get('lista-facturas-pagadas', [FacturasController::class, 'FacturasPagadas_index'])->name('facturas-pagadas');
    Route::get('lista-facturas-abonadas', [FacturasController::class, 'FacturasAbonada_index'])->name('facturas-abonadas');
    Route::get('lista-facturas-anuladas', [FacturasController::class, 'FacturasAnulada_index'])->name('facturas-anuladas');
    // Route::get('lista-facturas-reportes', [FacturasController::class, 'reportes'])->name('facturas-reportes');
    Route::get('lista-facturas', [FacturasController::class, 'index'])->name('facturas');
    Route::get('lista-cuentas', [CuentasPorCobrarController::class, 'index'])->name('cuentas');
});
Route::group(['middleware' => ['can:crear facturas']], function () {
    Route::get('crear-factura', [FacturasController::class, 'create'])->name('crear-factura');
    Route::post('store-factura', [FacturasController::class, 'store'])->name('store-factura');
    Route::post('store-abono', [AbonosController::class, 'store'])->name('store-abono');
    Route::get('get-punto_emision', [FacturasController::class, 'get_punto_emision'])->name('get-punto_emision');
    Route::post('generar-reporte', [ReportesController::class, 'generar_reportes'])->name('generar-reporte');
    Route::post('generar-reporte_anuladas', [ReportesController::class, 'generar_reportes_anuladas'])->name('generar-reporte_anuladas');
});
Route::group(['middleware' => ['can:modificar facturas']], function () {
    Route::get('editar-factura/{id_factura}', [FacturasController::class, 'edit'])->name('editar-factura');
    Route::put('update-factura', [FacturasController::class, 'update'])->name('update-factura');
    Route::get('editar-cuentas/{id}', [CuentasPorCobrarController::class, 'edit'])->name('editar-cuentas');
    Route::get('abonos/{id}', [AbonosController::class, 'edit'])->name('abonos');
    Route::put('update-cuentas', [CuentasPorCobrarController::class, 'update'])->name('update-cuentas');
});
Route::group(['middleware' => ['can:eliminar facturas']], function () {
    Route::delete('anular-factura/{id}', [FacturasController::class, 'anular_factura'])->name('anular-factura');
    Route::delete('eliminar-factura/{id}', [FacturasController::class, 'destroy'])->name('destroy-factura');
    // Route::delete('eliminar-abono/{id}', [AbonosController::class, 'destroy'])->name('destroy-abono');
});
//FACTURAS ---- establecimiento
Route::group(['middleware' => ['can:ver establecimiento']], function () {
    Route::get('lista-establecimientos', [EstablecimientosController::class, 'index'])->name('establecimientos');
});
Route::group(['middleware' => ['can:crear establecimiento']], function () {
    Route::get('crear-establecimiento', [EstablecimientosController::class, 'create'])->name('crear-establecimiento');
    Route::post('store-establecimiento', [EstablecimientosController::class, 'store'])->name('store-establecimiento');
});
Route::group(['middleware' => ['can:modificar establecimiento']], function () {
    Route::get('editar-establecimiento/{id}', [EstablecimientosController::class, 'edit'])->name('editar-establecimiento');
    Route::put('update-establecimiento', [EstablecimientosController::class, 'update'])->name('update-establecimiento');
});
Route::group(['middleware' => ['can:eliminar establecimiento']], function () {
    Route::delete('eliminar-establecimiento/{id}', [EstablecimientosController::class, 'destroy'])->name('destroy-establecimiento');
});
//FACTURAS ---- punto_emision
Route::group(['middleware' => ['can:ver punto_emision']], function () {
    Route::get('lista-punto_emision', [PuntosEmisionController::class, 'index'])->name('punto_emision');
});
Route::group(['middleware' => ['can:crear punto_emision']], function () {
    Route::get('crear-punto_emision', [PuntosEmisionController::class, 'create'])->name('crear-punto_emision');
    Route::post('store-punto_emision', [PuntosEmisionController::class, 'store'])->name('store-punto_emision');
});
Route::group(['middleware' => ['can:modificar punto_emision']], function () {
    Route::get('editar-punto_emision/{id}', [PuntosEmisionController::class, 'edit'])->name('editar-punto_emision');
    Route::put('update-punto_emision', [PuntosEmisionController::class, 'update'])->name('update-punto_emision');
});
Route::group(['middleware' => ['can:eliminar punto_emision']], function () {
    Route::delete('eliminar-punto_emision/{id}', [PuntosEmisionController::class, 'destroy'])->name('destroy-punto_emision');
});

//PAGOS
Route::group(['middleware' => ['can:ver pagos']], function () {
    Route::get('lista-pagos', [PagosController::class, 'index'])->name('pagos');
});
Route::group(['middleware' => ['can:crear pagos']], function () {
    Route::get('crear-pago', [PagosController::class, 'create'])->name('crear-pago');
    Route::post('store-pago', [PagosController::class, 'store'])->name('store-pago');
});
Route::group(['middleware' => ['can:modificar pagos']], function () {
    Route::get('editar-pago/{id}', [PagosController::class, 'edit'])->name('editar-pago');
    Route::put('update-pago', [PagosController::class, 'update'])->name('update-pago');
});
Route::group(['middleware' => ['can:eliminar pagos']], function () {
    Route::delete('destroy-pago/{id}', [PagosController::class, 'destroy'])->name('destroy-pago');
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

// Documentos
Route::group(['middleware' => ['can:ver custom_module']], function () {
    Route::get('lista-custom-module', [ModulosPersonalizadoController::class, 'index'])->name('custom-module');
    Route::get('carpeta/{id}', [ArchivosController::class, 'index'])->name('carpeta');
});

Route::group(['middleware' => ['can:crear custom_module']], function () {
    Route::get('crear-custom-module', [ModulosPersonalizadoController::class, 'create'])->name('crear-custom-module');
    Route::get('subir-archivo/{id}', [ArchivosController::class, 'create'])->name('subir-archivo');
    Route::post('store-archivo', [ArchivosController::class, 'store'])->name('store-archivo');
    Route::post('store-custom_module', [ModulosPersonalizadoController::class, 'store'])->name('store-custom_module');
});
Route::group(['middleware' => ['can:modificar custom_module']], function () {

    Route::get('edit-custom_module/{id}', [ModulosPersonalizadoController::class, 'edit'])->name('edit-custom_module');
    Route::put('update-custom_module', [ModulosPersonalizadoController::class, 'update'])->name('update-custom_module');
    Route::put('change-status-custom_module', [ModulosPersonalizadoController::class, 'chage_status'])->name('change-status-custom_module');
    Route::put('change-status-archivo', [ArchivosController::class, 'update'])->name('change-status-archivo');
});
Route::group(['middleware' => ['can:configuraciones']], function () {
    Route::get('lista-configuraciones', [ConfiguracionesGeneralesController::class, 'index'])->name('configuraciones');
    Route::get('editar-configuracion/{id}', [ConfiguracionesGeneralesController::class, 'edit'])->name('editar-configuracion');
    Route::put('update-configuracion', [ConfiguracionesGeneralesController::class, 'update'])->name('update-configuracion');
});
