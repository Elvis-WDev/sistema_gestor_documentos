<?php

namespace App\Http\Controllers;

use App\DataTables\ModuloPersonalizadoDataTable;
use Illuminate\Http\Request;

class ModulosPersonalizadoController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param ModuloPersonalizadoDataTable $ModuloPersonalizadoDataTable
     * @return Response
     */
    public function index(ModuloPersonalizadoDataTable $ModuloPersonalizadoDataTable)
    {
        return $ModuloPersonalizadoDataTable->render('pages.modulospesonalizados.index');
    }
    public function create()
    {
        return view('pages.modulospesonalizados.create');
    }
}