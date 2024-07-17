<?php

namespace App\Http\Controllers;

use App\DataTables\ModuloPersonalizadoDataTable;
use App\Models\ModuloPersonalizado;
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
    public function store(Request $request)
    {

        $request->validate([

            'NombreModulo' => ['required', 'string', 'max:255', 'unique:' . ModuloPersonalizado::class],

        ]);

        ModuloPersonalizado::create([
            'NombreModulo' => $request->NombreModulo,
        ]);


        flash('Carpeta creada correctamente!');

        return redirect()->route('custom-module');
    }
}
