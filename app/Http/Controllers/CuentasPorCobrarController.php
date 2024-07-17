<?php

namespace App\Http\Controllers;

use App\DataTables\AbonosDataTable;
use App\DataTables\CuentasPorCobrarDataTable;
use App\Models\Abonos;
use App\Models\Factura;
use Illuminate\Http\Request;

class CuentasPorCobrarController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param CuentasPorCobrarDataTable $CuentasPorCobrarDataTable
     * @return Response
     */
    public function index(CuentasPorCobrarDataTable $CuentasPorCobrarDataTable)
    {
        // $this->isSuperAdmin();
        return $CuentasPorCobrarDataTable->render('pages.facturas.cuentas_por_cobrar.index');
    }


    public function edit(int $id_factura)
    {
        $Factura = Factura::findOrFail($id_factura);

        return view('pages.facturas.cuentas_por_cobrar.edit', compact('Factura'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'RetencionIva' => 'required|numeric|gte:0',
            'RetencionFuente' => 'required|numeric|gte:0',
        ]);

        $factura = Factura::findOrFail($request->id);

        if ($factura->Estado != "Registrada") {

            flash()->error('No se puede editar cuenta ya abonada, anulada o pagada');
            return redirect()->route('editar-cuentas', $request->id);
        }

        $saldo = $factura->Total;
        // Restar retenciones
        $saldo -= $request->RetencionIva;
        $saldo -= $request->RetencionFuente;

        if ($saldo < 0) {
            flash()->error('Retención iva o retención fuente superan el total de la factura');
            return redirect()->route('editar-cuentas', $request->id);
        }

        $factura->RetencionIva = $request->RetencionIva;
        $factura->RetencionFuente = $request->RetencionFuente;

        $factura->save();

        flash('Cuenta actualizada correctamente!');

        return redirect()->route('cuentas');
    }
}
