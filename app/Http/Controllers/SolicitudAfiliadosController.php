<?php

namespace App\Http\Controllers;

use App\DataTables\SolicitudAfiliadosDatatables;
use App\Models\SolicitudAfiliados;
use Illuminate\Http\Request;

class SolicitudAfiliadosController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param SolicitudAfiliadosDatatables $SolicitudAfiliadosDatatables
     * @return Response
     */
    public function index(SolicitudAfiliadosDatatables $SolicitudAfiliadosDatatables)
    {
        // $this->isSuperAdmin();
        return $SolicitudAfiliadosDatatables->render('pages.solicitud_afiliados.index');
    }
    public function create()
    {
        return view('pages.solicitud_afiliados.create');
    }
    public function edit(int $id_solicitudAdiliado)
    {
        $SolicitudAfiliados = SolicitudAfiliados::findOrFail($id_solicitudAdiliado);

        return view('pages.solicitud_afiliados.edit', compact('SolicitudAfiliados'));
    }

    //editar-solicitud-afiliado
}
