<?php

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
    FilesController,
    ModulosPersonalizadoController,
    PagosController,
    PapeleraController,
    ProfileController,
    PuntosEmisionController,
    ReportesController,
    RolesController,
    SolicitudAfiliadosController,
    UsuariosController
};

require __DIR__ . '/auth.php';


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.edit');

    Route::patch('/perfil', [UsuariosController::class, 'updateProfile'])->name('perfil.update');

    Route::get('download/{path}', [FilesController::class, 'download'])->where('path', '.*')->name('download');
});

//USUARIOS Y ROLES
Route::group(['middleware' => ['can:ver usuario']], function () {
    Route::get('usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('roles', [RolesController::class, 'index'])->name('roles');
});

Route::group(['middleware' => ['can:crear usuario']], function () {
    Route::get('usuarios/crear', [UsuariosController::class, 'create'])->name('crear-usuario');

    Route::post('usuarios/store', [RegisteredUserController::class, 'store'])->name('store-usuario');

    Route::get('roles/crear', [RolesController::class, 'create'])->name('crear-rol');

    Route::post('roles/store', [RolesController::class, 'store'])->name('store-rol');
});

Route::group(['middleware' => ['can:modificar usuario']], function () {
    Route::get('usuarios/editar/{id}', [UsuariosController::class, 'edit'])->name('editar-usuario');

    Route::put('usuarios/update', [RegisteredUserController::class, 'update'])->name('update-usuario');

    Route::get('roles/editar/{id}', [RolesController::class, 'edit'])->name('editar-rol');

    Route::put('roles/update', [RolesController::class, 'update'])->name('update-rol');
});

Route::group(['middleware' => ['can:eliminar usuario']], function () {
    Route::delete('usuarios/eliminar/{id}', [UsuariosController::class, 'destroy'])->name('destroy-usuario');
    Route::delete('roles/eliminar/{id}', [RolesController::class, 'destroy'])->name('destroy-rol');
});

//FACTURAS
Route::group(['middleware' => ['can:ver facturas']], function () {
    Route::get('facturas', [FacturasController::class, 'index'])->name('facturas');
    Route::get('facturas/cuentas', [CuentasPorCobrarController::class, 'index'])->name('cuentas');
    Route::get('facturas/pagadas', [FacturasController::class, 'FacturasPagadas_index'])->name('facturas-pagadas');
    Route::get('facturas/abonadas', [FacturasController::class, 'FacturasAbonada_index'])->name('facturas-abonadas');
    Route::get('facturas/anuladas', [FacturasController::class, 'FacturasAnulada_index'])->name('facturas-anuladas');
});

Route::group(['middleware' => ['can:crear facturas']], function () {
    Route::get('facturas/crear', [FacturasController::class, 'create'])->name('crear-factura');
    Route::post('facturas/store', [FacturasController::class, 'store'])->name('store-factura');
    Route::get('punto_emision/get', [FacturasController::class, 'get_punto_emision'])->name('get-punto_emision');
});
Route::group(['middleware' => ['can:modificar facturas']], function () {
    Route::get('facturas/editar/{id}', [FacturasController::class, 'edit'])->name('editar-factura');
    Route::put('facturas/update', [FacturasController::class, 'update'])->name('update-factura');
    Route::get('cuentas/editar/{id}', [CuentasPorCobrarController::class, 'edit'])->name('editar-cuentas');

    Route::put('cuentas/update', [CuentasPorCobrarController::class, 'update'])->name('update-cuentas');
});
Route::group(['middleware' => ['can:eliminar facturas']], function () {
    Route::delete('facturas/eliminar/{id}', [FacturasController::class, 'destroy'])->name('destroy-factura');
});
Route::group(['middleware' => ['can:anular facturas']], function () {
    Route::delete('facturas/anular/{id}', [FacturasController::class, 'anular_factura'])->name('anular-factura');
});
Route::group(['middleware' => ['can:abonar facturas']], function () {
    Route::get('abonos/{id}', [AbonosController::class, 'edit'])->name('abonos');
    Route::post('abonos/store', [AbonosController::class, 'store'])->name('store-abono');
});

Route::group(['middleware' => ['can:reporte facturas']], function () {
    Route::post('facturas/generar-reporte', [ReportesController::class, 'generar_reportes'])->name('generar-reporte');
    Route::post('facturas/generar-reporte-anuladas', [ReportesController::class, 'generar_reportes_anuladas'])->name('generar-reporte_anuladas');
});
//FACTURAS ---- establecimiento
Route::group(['middleware' => ['can:ver establecimiento']], function () {
    Route::get('establecimientos', [EstablecimientosController::class, 'index'])->name('establecimientos');
});
Route::group(['middleware' => ['can:crear establecimiento']], function () {
    Route::get('establecimientos/crear', [EstablecimientosController::class, 'create'])->name('crear-establecimiento');
    Route::post('establecimientos/store', [EstablecimientosController::class, 'store'])->name('store-establecimiento');
});
Route::group(['middleware' => ['can:modificar establecimiento']], function () {
    Route::get('establecimientos/editar/{id}', [EstablecimientosController::class, 'edit'])->name('editar-establecimiento');
    Route::put('establecimientos/update', [EstablecimientosController::class, 'update'])->name('update-establecimiento');
});
Route::group(['middleware' => ['can:eliminar establecimiento']], function () {
    Route::delete('establecimientos/eliminar/{id}', [EstablecimientosController::class, 'destroy'])->name('destroy-establecimiento');
});
//FACTURAS ---- punto_emision
Route::group(['middleware' => ['can:ver punto_emision']], function () {
    Route::get('punto_emision', [PuntosEmisionController::class, 'index'])->name('punto_emision');
});
Route::group(['middleware' => ['can:crear punto_emision']], function () {
    Route::get('punto_emision/crear', [PuntosEmisionController::class, 'create'])->name('crear-punto_emision');
    Route::post('punto_emision/store', [PuntosEmisionController::class, 'store'])->name('store-punto_emision');
});
Route::group(['middleware' => ['can:modificar punto_emision']], function () {
    Route::get('punto_emision/editar/{id}', [PuntosEmisionController::class, 'edit'])->name('editar-punto_emision');
    Route::put('punto_emision/update', [PuntosEmisionController::class, 'update'])->name('update-punto_emision');
});
Route::group(['middleware' => ['can:eliminar punto_emision']], function () {
    Route::delete('punto_emision/eliminar/{id}', [PuntosEmisionController::class, 'destroy'])->name('destroy-punto_emision');
});

//PAGOS
Route::group(['middleware' => ['can:ver pagos']], function () {
    Route::get('pagos', [PagosController::class, 'index'])->name('pagos');
});
Route::group(['middleware' => ['can:crear pagos']], function () {
    Route::get('pagos/crear', [PagosController::class, 'create'])->name('crear-pago');
    Route::post('pagos/store', [PagosController::class, 'store'])->name('store-pago');
});
Route::group(['middleware' => ['can:modificar pagos']], function () {
    Route::get('pagos/editar/{id}', [PagosController::class, 'edit'])->name('editar-pago');
    Route::put('pagos/update', [PagosController::class, 'update'])->name('update-pago');
});
Route::group(['middleware' => ['can:eliminar pagos']], function () {
    Route::delete('pagos/destroy/{id}', [PagosController::class, 'destroy'])->name('destroy-pago');
});

//SolicitudAfiliado
Route::group(['middleware' => ['can:ver SolicitudAfiliado']], function () {
    Route::get('solicitud-afiliados', [SolicitudAfiliadosController::class, 'index'])->name('solicitud-afiliados');
});
Route::group(['middleware' => ['can:crear SolicitudAfiliado']], function () {
    Route::get('solicitud-afiliados/crear', [SolicitudAfiliadosController::class, 'create'])->name('crear-solicitud-afiliados');
    Route::post('solicitud-afiliados/store', [SolicitudAfiliadosController::class, 'store'])->name('store-solicitud');
});
Route::group(['middleware' => ['can:modificar SolicitudAfiliado']], function () {
    Route::get('solicitud-afiliados/editar/{id}', [SolicitudAfiliadosController::class, 'edit'])->name('editar-solicitud-afiliado');
    Route::put('solicitud-afiliados/update', [SolicitudAfiliadosController::class, 'update'])->name('update-solicitud');
});
Route::group(['middleware' => ['can:eliminar SolicitudAfiliado']], function () {
    Route::delete('solicitud-afiliados/destroy/{id}', [SolicitudAfiliadosController::class, 'destroy'])->name('destroy-solicitud');
});

// Papelera
Route::group(['middleware' => ['can:papelera']], function () {
    Route::get('papelera', [PapeleraController::class, 'index'])->name('pepelera');
    Route::delete('papelera/destroy/{id}', [PapeleraController::class, 'destroy'])->name('destroy-papelera');
});

// Documentos
Route::group(['middleware' => ['can:ver custom_module']], function () {
    Route::get('carpetas', [ModulosPersonalizadoController::class, 'index'])->name('custom-module');
    Route::get('carpetas/archivos/{id}', [ArchivosController::class, 'index'])->name('carpeta');
});

Route::group(['middleware' => ['can:crear custom_module']], function () {
    Route::get('carpetas/crear', [ModulosPersonalizadoController::class, 'create'])->name('crear-custom-module');
    Route::post('carpetas/store', [ModulosPersonalizadoController::class, 'store'])->name('store-custom_module');
    Route::get('carpetas/archivos/subir/{id}', [ArchivosController::class, 'create'])->name('subir-archivo');
    Route::post('carpetas/archivos/store', [ArchivosController::class, 'store'])->name('store-archivo');
});

Route::group(['middleware' => ['can:modificar custom_module']], function () {
    Route::get('carpetas/edit/{id}', [ModulosPersonalizadoController::class, 'edit'])->name('edit-custom_module');
    Route::put('carpetas/update', [ModulosPersonalizadoController::class, 'update'])->name('update-custom_module');
    Route::put('carpetas/change-status', [ModulosPersonalizadoController::class, 'chage_status'])->name('change-status-custom_module');
    Route::put('carpetas/archivos/change-status', [ArchivosController::class, 'update'])->name('change-status-archivo');
});

// Configuracione generales
Route::group(['middleware' => ['can:configuraciones']], function () {
    Route::get('configuraciones', [ConfiguracionesGeneralesController::class, 'index'])->name('configuraciones');
    Route::get('configuraciones/editar/{id}', [ConfiguracionesGeneralesController::class, 'edit'])->name('editar-configuracion');
    Route::put('configuraciones/update', [ConfiguracionesGeneralesController::class, 'update'])->name('update-configuracion');
});
