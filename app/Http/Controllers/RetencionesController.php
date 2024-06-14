<?php

namespace App\Http\Controllers;

use App\DataTables\RetencionesDataTable;
use App\Models\Retenciones;
use Illuminate\Http\Request;

class RetencionesController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param RetencionesDataTable $RetencionesDataTable
     * @return Response
     */
    public function index(RetencionesDataTable $RetencionesDataTable)
    {
        // $this->isSuperAdmin();
        return $RetencionesDataTable->render('pages.retenciones.index');
    }
    public function create()
    {
        return view('pages.retenciones.create');
    }

    public function edit(int $id)
    {
        $Retencion = Retenciones::findOrFail($id);

        return view('pages.retenciones.edit', compact('Retencion'));
    }
}
