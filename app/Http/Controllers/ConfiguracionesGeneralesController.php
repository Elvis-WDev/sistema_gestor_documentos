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
        // dd($id_factura);
        $Config_generales = configuraciones_generales::findOrFail($id);

        return view('pages.config_general.edit', compact('Config_generales'));
    }
}
