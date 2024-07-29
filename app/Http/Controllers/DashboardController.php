<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Factura;
use App\Models\Pago;
use App\Models\SolicitudAfiliados;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $CantidadFacturas = Factura::all()->count();
            $CantidadPagos = Pago::all()->count();
            $CantidadSolicitudAfiliados = SolicitudAfiliados::all()->count();
            $CantidadUsuarios = User::all()->count();

            $CantidadFacturasPagadas = Factura::where('Estado', 'Pagada')->count();
            $CantidadFacturasAbonadas = Factura::where('Estado', 'Abonada')->count();
            $CantidadFacturasAnuladas = Factura::where('Estado', 'Anulada')->count();
            $CantidadFacturasRegistradas = Factura::where('Estado', 'Registrada')->count();

            $Actividades = Actividad::with('usuario')->latest()->take(20)->get();

            $DataFacturasTotal = Factura::select(
                DB::raw('DATE_FORMAT(FechaEmision, "%Y-%m-%d") as FechaEmision'),
                DB::raw('SUM(Total) as value')
            )->groupBy('FechaEmision')->get();

            $DataFacturasTotal = $DataFacturasTotal->map(function ($item) {
                return [
                    'FechaEmision' => $item->FechaEmision,
                    'value' => $item->value
                ];
            })->toArray();

            $Data = [

                "CantidadFacturas" => $CantidadFacturas,
                "CantidadPagos" => $CantidadPagos,
                "CantidadSolicitudAfiliados" => $CantidadSolicitudAfiliados,
                "CantidadUsuarios" => $CantidadUsuarios,
                "CantidadFacturasPagadas" => $CantidadFacturasPagadas,
                "CantidadFacturasAbonadas" => $CantidadFacturasAbonadas,
                "CantidadFacturasAnuladas" => $CantidadFacturasAnuladas,
                "CantidadFacturasRegistradas" => $CantidadFacturasRegistradas,
                "Actividades" =>  $Actividades,
                "DataFacturasTotal" =>  $DataFacturasTotal,

            ];

            return view('pages.dashboard', compact('Data'));
        } catch (Exception $e) {
            // Manejo de excepciones en caso de error al recuperar datos
            Log::error('Error en el método index del dashboard', ['exception' => $e]);
            flash()->error('Ocurrió un problema al cargar los datos del dashboard. Por favor, inténtelo de nuevo.');
            return redirect()->route('dashboard');
        }
    }
}
