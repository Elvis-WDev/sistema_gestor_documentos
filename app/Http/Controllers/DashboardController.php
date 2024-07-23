<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Factura;
use App\Models\NotasCredito;
use App\Models\Pago;
use App\Models\Retenciones;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $CantidadFacturas = Factura::all()->count();
        $CantidadPagos = Pago::all()->count();
        $CantidadNotasCredito = NotasCredito::all()->count();
        $CantidadRetenciones = Retenciones::all()->count();

        $CantidadFacturasPagadas = Factura::where('Estado', 'Pagada')->count();
        $CantidadFacturasAbonadas = Factura::where('Estado', 'Abonada')->count();
        $CantidadFacturasAnuladas = Factura::where('Estado', 'Anulada')->count();
        $CantidadFacturasRegistradas = Factura::where('Estado', 'Registrada')->count();

        $Actividades = Actividad::with('usuario')->latest()->take(20)->get();

        $DataFacturasTotal = Factura::select(
            DB::raw('DATE_FORMAT(FechaEmision, "%Y-%m-%d") as FechaEmision'),
            DB::raw('SUM(Total) as value')
        )->groupBy('FechaEmision')->get();

        // Convert the collection to an array
        $DataFacturasTotal = $DataFacturasTotal->map(function ($item) {
            return [
                'FechaEmision' => $item->FechaEmision,
                'value' => $item->value
            ];
        })->toArray();

        $Data = [

            "CantidadFacturas" => $CantidadFacturas,
            "CantidadPagos" => $CantidadPagos,
            "CantidadNotasCredito" => $CantidadNotasCredito,
            "CantidadRetenciones" => $CantidadRetenciones,
            "CantidadFacturasPagadas" => $CantidadFacturasPagadas,
            "CantidadFacturasAbonadas" => $CantidadFacturasAbonadas,
            "CantidadFacturasAnuladas" => $CantidadFacturasAnuladas,
            "CantidadFacturasRegistradas" => $CantidadFacturasRegistradas,
            "Actividades" =>  $Actividades,
            "DataFacturasTotal" =>  $DataFacturasTotal,

        ];

        return view('pages.dashboard', compact('Data'));
    }
}
