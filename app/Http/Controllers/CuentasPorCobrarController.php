<?php

namespace App\Http\Controllers;

use App\DataTables\CuentasPorCobrarDataTable;
use App\Models\Factura;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CuentasPorCobrarController extends Controller
{

    use RegistrarActividad;

    /**
     * Display a listing of the FileType.
     *
     * @param CuentasPorCobrarDataTable $CuentasPorCobrarDataTable
     * @return Response
     */
    public function index(CuentasPorCobrarDataTable $CuentasPorCobrarDataTable)
    {
        try {
            return $CuentasPorCobrarDataTable->render('pages.facturas.cuentas_por_cobrar.index');
        } catch (Exception $e) {
            // Manejar excepciones y registrar el error
            Log::error('Error al cargar el DataTable de cuentas por cobrar', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar las cuentas por cobrar. Por favor, inténtalo de nuevo.');
            return redirect()->route('facturas');
        }
    }


    public function edit(int $id_factura)
    {
        try {

            if (!is_numeric($id_factura) || $id_factura <= 0) {
                flash()->error('ID inválido.');
                return redirect()->route('cuentas');
            }

            $Factura = Factura::findOrFail($id_factura);

            return view('pages.facturas.cuentas_por_cobrar.edit', compact('Factura'));
        } catch (ModelNotFoundException $e) {
            // Manejar el caso en que la factura no se encuentra
            Log::error('Factura no encontrada', ['id_factura' => $id_factura, 'exception' => $e]);
            flash()->error('La factura solicitada no existe.');
            return redirect()->route('cuentas');
        } catch (Exception $e) {
            // Manejar otras excepciones generales
            Log::error('Error al cargar la factura para edición', ['id_factura' => $id_factura, 'exception' => $e]);
            flash()->error('Hubo un problema al cargar la factura para edición. Por favor, inténtalo de nuevo.');
            return redirect()->route('cuentas');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'RetencionIva' => 'required|numeric|gte:0',
            'RetencionFuente' => 'required|numeric|gte:0',
        ]);

        try {

            $factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($request->id);

            if ($factura->Estado != "Registrada") {

                flash()->error('No se puede editar cuenta ya abonada, anulada o pagada');
                return redirect()->route('editar-cuentas', $request->id);
            }

            $saldo = $factura->Total;
            // Restar retenciones
            $saldo -= $request->RetencionIva;
            $saldo -= $request->RetencionFuente;

            if ($saldo < 0) {
                flash()->error('Retención iva o retención fuente superan el total de la factura');
                return redirect()->route('editar-cuentas', $request->id);
            }

            $factura->RetencionIva = $request->RetencionIva;
            $factura->RetencionFuente = $request->RetencionFuente;

            $factura->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha editado una cuenta",
                "Factura Nro: " . $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial
            );

            flash('Cuenta actualizada correctamente!');

            return redirect()->route('cuentas');
        } catch (ModelNotFoundException $e) {

            // Manejar caso cuando no se encuentra la factura o establecimiento/punto de emisión
            Log::error('Factura, establecimiento o punto de emisión no encontrados', ['exception' => $e]);
            flash()->error('No se pudo encontrar la factura o datos relacionados.');
            return redirect()->route('editar-cuentas', $request->id);
        } catch (Exception $e) {

            // Manejar cualquier otro error
            Log::error('Error al actualizar cuenta', ['exception' => $e]);
            flash()->error('Ocurrió un problema al actualizar la cuenta. Por favor, inténtalo de nuevo.');
            return redirect()->route('editar-cuentas', $request->id);
        }
    }
}
