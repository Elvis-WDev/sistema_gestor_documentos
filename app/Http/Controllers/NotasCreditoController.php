<?php

namespace App\Http\Controllers;

use App\DataTables\NotasCreditoDataTable;
use App\Models\NotasCredito;
use Illuminate\Http\Request;

class NotasCreditoController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param NotasCreditoDataTable $NotasCreditoDataTable
     * @return Response
     */
    public function index(NotasCreditoDataTable $NotasCreditoDataTable)
    {
        // $this->isSuperAdmin();
        return $NotasCreditoDataTable->render('pages.notas_credito.index');
    }

    public function create()
    {
        return view('pages.notas_credito.create');
    }

    public function edit(int $id)
    {
        // dd($id_factura);
        $NotaCredito = NotasCredito::findOrFail($id);

        return view('pages.notas_credito.edit', compact('NotaCredito'));
    }
}
