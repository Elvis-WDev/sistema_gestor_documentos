<?php

namespace App\Http\Controllers;

use App\DataTables\ConfiguracionesGeneralesDatatables;
use App\Models\configuraciones_generales;
use Illuminate\Http\Request;

class ConfiguracionesGeneralesController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param ConfiguracionesGeneralesDatatables $ConfiguracionesGeneralesDatatables
     * @return Response
     */
    public function index(ConfiguracionesGeneralesDatatables $ConfiguracionesGeneralesDatatables)
    {
        // $this->isSuperAdmin();
        return $ConfiguracionesGeneralesDatatables->render('pages.config_general.index');
    }
    public function create()
    {
        return view('pages.config_general.edit');
    }

    public function edit(int $id)
    {
        $Config_generales = configuraciones_generales::findOrFail($id);

        return view('pages.config_general.edit', compact('Config_generales'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'archivos_permitidos.*' => 'required|string|max:255',
            'cantidad_permitidos' => 'required|integer',
            'tamano_maximo_permitido' => 'required|integer',
        ]);


        // Formateo de arreglo a campo que acepta VFalidation doc,pdf,etc
        $mimesPermitidos = '';

        foreach ($request->archivos_permitidos as $key => $value) {
            $mimesPermitidos .= $value . ',';
        }

        $mimesPermitidos = substr($mimesPermitidos, 0, -1);

        $configuracion = configuraciones_generales::findOrFail($request->id);

        $configuracion->nombre = $request->nombre;
        $configuracion->archivos_permitidos = $mimesPermitidos;
        $configuracion->cantidad_permitidos = $request->cantidad_permitidos;
        $configuracion->tamano_maximo_permitido = $request->tamano_maximo_permitido;

        $configuracion->save();

        flash('Configuracion general actualizada correctamente!');

        return redirect()->route('configuraciones');
    }
}
