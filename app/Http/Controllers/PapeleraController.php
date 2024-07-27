<?php

namespace App\Http\Controllers;

use App\DataTables\PapeleraDataTable;
use App\Models\Papelera;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PapeleraController extends Controller
{

    use RegistrarActividad;

    public function index(PapeleraDataTable $PapeleraDataTable)
    {
        return $PapeleraDataTable->render('pages.papelera.index');
    }

    public function destroy(Int $id)
    {
        try {

            $Papelera = Papelera::findOrFail($id);

            $tempPapelera = $Papelera;

            if (!is_null($Papelera->Archivos)) {
                $archivos = json_decode($Papelera->Archivos, true);

                foreach ($archivos as $archivo) {

                    if (Storage::disk('public')->exists($archivo)) {
                        Storage::disk('public')->delete($archivo);
                    }
                }
            }

            $Papelera->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado archivos de la papelera",
                "Descripción: " .  $tempPapelera->Total
            );

            flash('Archivos de papelera eliminados correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Archivos de papelera eliminados correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Ah ocurrido un problema al eliminar archivos.']);
        }
    }
}
