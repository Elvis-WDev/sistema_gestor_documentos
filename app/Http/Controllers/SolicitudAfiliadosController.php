<?php

namespace App\Http\Controllers;

use App\DataTables\SolicitudAfiliadosDatatables;
use App\Models\SolicitudAfiliados;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

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
        try {
            return $SolicitudAfiliadosDatatables->render('pages.solicitud_afiliados.index');
        } catch (Exception $e) {
            // Manejar excepciones y registrar el error
            Log::error('Error al cargar el DataTable de solicitud_afiliados', ['exception' => $e]);
            Alert::erorr('Hubo un problema al cargar las solicitudes de afiliados. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }
    public function create()
    {
        try {
            return view('pages.solicitud_afiliados.create');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la vista de solicitud_afiliados', ['exception' => $e]);
            Alert::erorr('Hubo un problema al cargar la página de solicitud de afiliados. Por favor, inténtalo de nuevo.');
            return redirect()->route('solicitud-afiliados');
        }
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

        try {

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

            toast('Solicitud registrada correctamente!', 'success');

            return redirect()->route('solicitud-afiliados');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al registrar solicitud de afiliado', ['exception' => $e]);
            Alert::erorr('Hubo un problema al registrar la solicitud.');
            return redirect()->route('solicitud-afiliados');
        }
    }

    public function edit(int $id)
    {
        try {
            $SolicitudAfiliados = SolicitudAfiliados::findOrFail($id);

            return view('pages.solicitud_afiliados.edit', compact('SolicitudAfiliados'));
        } catch (ModelNotFoundException $e) {
            // Manejo de excepción si no se encuentra el modelo
            Log::error('Solicitud de afiliado no encontrada', ['id' => $id, 'exception' => $e]);
            Alert::erorr('La solicitud de afiliado no fue encontrada.');
            return redirect()->route('solicitud-afiliados');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al obtener solicitud de afiliado', ['id' => $id, 'exception' => $e]);
            Alert::erorr('Hubo un problema al obtener la solicitud de afiliado.');
            return redirect()->route('solicitud-afiliados');
        }
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

        try {

            $solicitud = SolicitudAfiliados::findOrFail($request->id);

            if ($request->hasFile('Archivos')) {

                $archivos = $this->updateMultiFile($request, 'Archivos', 'uploads/solicitud_afiliados', 'old_archivos', 'uploads/trash/solicitud_afiliados/', "Archivos eliminados al editar una solicitud afiliados con prefijo: # " . $request->Prefijo);

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

            toast('Solicitud actualizada correctamente!', 'success');

            return redirect()->route('solicitud-afiliados');
        } catch (Exception $e) {
            // Manejo de otros errores inesperados
            Log::error('Error al actualizar solicitud de afiliado', ['exception' => $e]);
            Alert::error('Hubo un problema al actualizar la solicitud.');
            return redirect()->route('solicitud-afiliados');
        }
    }

    public function destroy(Int $id)
    {
        try {

            $solicitud = SolicitudAfiliados::findOrFail($id);

            $tempSolicitud = $solicitud;

            $this->DestroyFiles($solicitud->Archivos, 'uploads/trash/solicitud_afiliados/', 'Archivos eliminados al eliminar una solicitud afiliado: $' . $tempSolicitud->Prefijo);

            $solicitud->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado una solicitud afiliado",
                "Prefijo: $" .  $tempSolicitud->Prefijo
            );

            return response()->json(['status' => 'success', 'message' => 'Solicitud eliminada correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al eliminar la solicitud.']);
        }
    }
}
