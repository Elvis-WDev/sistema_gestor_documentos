<?php

namespace App\Http\Controllers;

use App\DataTables\AbonosDataTable;
use App\DataTables\CuentasPorCobrarDataTable;
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
            'RetencionIva' => 'required|numeric',
            'RetencionFuente' => 'required|numeric',
        ]);

        $factura = Factura::findOrFail($request->id);

        $factura->RetencionIva = $request->RetencionIva;
        $factura->RetencionFuente = $request->RetencionFuente;

        $factura->save();

        flash('Cuenta actualizada correctamente!');

        return redirect()->route('cuentas');
    }
}
