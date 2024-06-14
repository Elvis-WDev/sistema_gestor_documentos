<?php

namespace App\Http\Controllers;

use App\DataTables\FacturasDataTable;
use App\Models\Factura;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param FacturasDataTable $FacturasDataTable
     * @return Response
     */
    public function index(FacturasDataTable $FacturasDataTable)
    {
        // $this->isSuperAdmin();
        return $FacturasDataTable->render('pages.facturas.index');
    }

    public function create()
    {
        return view('pages.facturas.create');
    }

    public function edit(int $id_factura)
    {
        $Factura = Factura::findOrFail($id_factura);

        return view('pages.facturas.edit', compact('Factura'));
    }
}