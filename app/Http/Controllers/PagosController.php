<?php

namespace App\Http\Controllers;

use App\DataTables\PagosDataTable;
use App\Models\Factura;
use App\Models\Pago;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PagosController extends Controller
{
    use FilesUploadTrait, RegistrarActividad;
    /**
     * Display a listing of the FileType.
     *
     * @param PagosDataTable $PagosDataTable
     * @return Response
     */
    public function index(PagosDataTable $PagosDataTable)
    {
        return $PagosDataTable->render('pages.pagos.index');
    }

    public function create()
    {
        return view('pages.pagos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_factura' => 'required|numeric',
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'FechaPago' => 'required|date',
            'Total' => 'required|numeric|gt:0',
        ]);

        // Procesamiento de archivos utilizando uploadMultiFile
        $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/pagos');

        Pago::create([
            'id_factura' => $request->id_factura,
            'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
            'Total' => $request->Total,
            'FechaPago' => $request->FechaPago,
        ]);

        $this->Actividad(
            Auth::user()->id,
            "Ha registrado un pago",
            "Monto: $" . $request->Total
        );

        flash('Pago registrado correctamente!');

        return redirect()->route('pagos');
    }

    public function edit(int $id)
    {
        $Pago = Pago::with(['factura'])->findOrFail($id);

        return view('pages.pagos.edit', compact('Pago'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id_pago' => 'required|numeric',
            'old_archivos' => 'required|string|max:1000',
            'id_factura' => 'required|numeric',
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'FechaPago' => 'required|date',
            'Total' => 'required|numeric|gt:0',
        ]);

        $Pago = Pago::findOrFail($request->id_pago);

        if ($request->hasFile('Archivos')) {

            $archivos = $this->updateMultiFile($request, 'Archivos', 'uploads/pagos', 'old_archivos');

            $Pago->Archivos = $archivos;
        } elseif ($request->filled('old_archivos')) {

            $Pago->Archivos = $request->old_archivos;
        } else {

            $Pago->Archivos = null;
        }

        $Pago->id_factura = $request->id_factura;
        $Pago->FechaPago = $request->FechaPago;
        $Pago->Total = $request->Total;
        $Pago->save();

        $this->Actividad(
            Auth::user()->id,
            "Ha editado un pago",
            "Monto: $" . $request->Total
        );

        flash('Pago actualizado correctamente!');

        return redirect()->route('pagos');
    }

    public function destroy(string $id)
    {
        try {

            $Pago = Pago::findOrFail($id);

            $tempPago = $Pago;

            if (!is_null($Pago->Archivos)) {
                $archivos = json_decode($Pago->Archivos, true);

                foreach ($archivos as $archivo) {
                    $trashPath = 'uploads/trash/pagos/' . basename($archivo);
                    Storage::disk('public')->move($archivo, $trashPath);
                }
            }

            $Pago->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un pago",
                "Monto: $" .  $tempPago->Total
            );

            flash('Pago eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Pago eliminado correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Ah ocurrido un problema al eliminar pago.']);
        }
    }
}
