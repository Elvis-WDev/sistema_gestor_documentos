<?php

namespace App\Http\Controllers;

use App\DataTables\PagosDataTable;
use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param PagosDataTable $PagosDataTable
     * @return Response
     */
    public function index(PagosDataTable $PagosDataTable)
    {
        return $PagosDataTable->render('pages.pagos.index');
    }
    public function create()
    {
        return view('pages.pagos.create');
    }
    public function edit(int $id_pago)
    {
        $Pago = Pago::findOrFail($id_pago);

        $TodasLasFacturas = Factura::all();

        return view('pages.pagos.edit', compact('Pago', 'TodasLasFacturas'));
    }
}
