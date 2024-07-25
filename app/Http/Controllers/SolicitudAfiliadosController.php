<?php

namespace App\Http\Controllers;

use App\DataTables\SolicitudAfiliadosDatatables;
use App\Models\SolicitudAfiliados;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SolicitudAfiliadosController extends Controller
{
    use FilesUploadTrait, RegistrarActividad;

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

    public function store(Request $request)
    {
        $request->validate([
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'Prefijo' => 'required|numeric|unique:' . SolicitudAfiliados::class,
            'NombreCliente' => 'required|string|max:255',
            'FechaSolicitud' => 'required|date',
        ]);

        $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/solicitud_afiliados');

        SolicitudAfiliados::create([
            'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
            'Prefijo' => $request->Prefijo,
            'NombreCliente' => $request->NombreCliente,
            'FechaSolicitud' => $request->FechaSolicitud,
        ]);

        $this->Actividad(
            Auth::user()->id,
            "Ha registrado una solicitud afiliado",
            "Prefijo: " .  $request->Prefijo
        );

        flash('Solicitud registrada correctamente!');

        return redirect()->route('solicitud-afiliados');
    }

    public function edit(int $id)
    {
        $SolicitudAfiliados = SolicitudAfiliados::findOrFail($id);

        return view('pages.solicitud_afiliados.edit', compact('SolicitudAfiliados'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'Prefijo' => ['required', 'numeric', Rule::unique('solicitud_afiliados')->ignore($request->id)],
            'NombreCliente' => 'required|string|max:255',
            'FechaSolicitud' => 'required|date',
        ]);

        $solicitud = SolicitudAfiliados::findOrFail($request->id);

        if ($request->hasFile('Archivos')) {

            $archivos = $this->updateMultiFile($request, 'Archivos', 'uploads/solicitud_afiliados', 'old_archivos');

            $solicitud->Archivos = $archivos;
        } elseif ($request->filled('old_archivos')) {

            $solicitud->Archivos = $request->old_archivos;
        } else {

            $solicitud->Archivos = null;
        }


        $solicitud->Prefijo = $request->Prefijo;
        $solicitud->NombreCliente = $request->NombreCliente;
        $solicitud->FechaSolicitud = $request->FechaSolicitud;
        $solicitud->save();


        $this->Actividad(
            Auth::user()->id,
            "Ha editado una solicitud afiliado",
            "Prefijo: " .  $request->Prefijo
        );

        flash('Solicitud actualizada correctamente!');

        return redirect()->route('solicitud-afiliados');
    }

    public function destroy(Int $id)
    {
        try {

            $solicitud = SolicitudAfiliados::findOrFail($id);

            $tempSolicitud = $solicitud;

            if (!is_null($solicitud->Archivos)) {
                $archivos = json_decode($solicitud->Archivos, true);

                foreach ($archivos as $archivo) {
                    $trashPath = 'uploads/trash/solicitud_afiliados/' . basename($archivo);
                    Storage::disk('public')->move($archivo, $trashPath);
                }
            }

            $solicitud->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado una solicitud afiliado",
                "Prefijo: $" .  $tempSolicitud->Prefijo
            );

            flash('Solicitud eliminada correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Solicitud eliminada correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Ah ocurrido un problema al eliminar la solicitud.']);
        }
    }
}
