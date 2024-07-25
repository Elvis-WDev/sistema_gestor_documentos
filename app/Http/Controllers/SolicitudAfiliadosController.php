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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_factura' => 'required|numeric',
    //         'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
    //         'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
    //         'FechaPago' => 'required|date',
    //         'Total' => 'required|numeric|gt:0',
    //     ]);

    //     // Procesamiento de archivos utilizando uploadMultiFile
    //     $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/pagos');

    //     Pago::create([
    //         'id_factura' => $request->id_factura,
    //         'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
    //         'Total' => $request->Total,
    //         'FechaPago' => $request->FechaPago,
    //     ]);

    //     $this->Actividad(
    //         Auth::user()->id,
    //         "Ha registrado un pago",
    //         "Monto: $" . $request->Total
    //     );

    //     flash('Pago registrado correctamente!');

    //     return redirect()->route('pagos');
    // }
}
