<?php

namespace App\Http\Controllers;

use App\DataTables\AbonosDataTable;
use App\Models\Abonos;
use App\Models\Factura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AbonosController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'factura_id' => 'required|integer|exists:facturas,id_factura',
            'valor_abono' => 'required|numeric|gt:0',
            'fecha_abonado' => 'required|date',
        ]);

        $factura = Factura::findOrFail($validatedData['factura_id']);

        if (in_array($factura->Estado, ['Pagada', 'Anulada'])) {
            flash()->error('No se pueden registrar abonos en una factura ya pagada o anulada.');
            return redirect()->route('abonos', $factura->id_factura);
        }

        $ultimoAbono = Abonos::where('factura_id', $factura->id_factura)
            ->orderBy('fecha_abonado', 'desc')
            ->orderBy('id', 'desc') // Ordenar también por id para asegurar el orden correcto
            ->first();

        $nuevoSaldo = $ultimoAbono
            ? $ultimoAbono->saldo_factura - $validatedData['valor_abono']
            : $factura->Total - $validatedData['valor_abono'];

        if ($nuevoSaldo < 0) {
            flash()->error('El valor del abono excede el saldo de la factura.');
            return redirect()->route('abonos', $factura->id_factura);
        }

        Abonos::create([
            'factura_id' => $validatedData['factura_id'],
            'total_factura' => $factura->Total, // Usar el total de la factura de la base de datos
            'valor_abono' => $validatedData['valor_abono'],
            'saldo_factura' => $nuevoSaldo,
            'fecha_abonado' => $validatedData['fecha_abonado'],
        ]);

        $factura->update(['Estado' => $nuevoSaldo == 0 ? 1 : 3]);

        if ($nuevoSaldo == 0) {
            flash('Factura pagada con éxito!');
            return redirect()->route('cuentas');
        }
        flash('Abono registrado correctamente!');
        return redirect()->route('abonos', $factura->id_factura);
    }

    /**
     * Display a listing of the FileType.
     *
     * @param int $id_factura
     * @param AbonosDataTable $abonosDataTable
     * @return Response
     */
    public function edit(int $id_factura, AbonosDataTable $abonosDataTable)
    {
        $Factura = Factura::findOrFail($id_factura);
        $abonosDataTable->setFacturaId($id_factura);

        return $abonosDataTable->render('pages.facturas.cuentas_por_cobrar.abonos.index', compact('Factura'));
    }
}
