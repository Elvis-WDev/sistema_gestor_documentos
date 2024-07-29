<?php

namespace App\Http\Controllers;

use App\DataTables\AbonosDataTable;
use App\Models\Abonos;
use App\Models\Factura;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class AbonosController extends Controller
{
    use RegistrarActividad;

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'factura_id' => 'required|integer|exists:facturas,id_factura',
            'valor_abono' => 'required|numeric|gt:0',
            'fecha_abonado' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($validatedData['factura_id']);

            if (in_array($factura->Estado, ['Pagada', 'Anulada'])) {
                flash()->error('No se pueden registrar abonos en una factura ya pagada o anulada.');
                return redirect()->route('abonos', $factura->id_factura);
            }

            $retencionIva = $factura->RetencionIva ?: 0;
            $retencionFuente = $factura->RetencionFuente ?: 0;

            $totalRetenciones = $retencionIva + $retencionFuente;
            $saldoInicial = $factura->Total - $totalRetenciones;

            if ($totalRetenciones > $factura->Total) {
                flash()->error('Las retenciones no pueden exceder el valor total de la factura.');
                DB::rollBack();
                return redirect()->route('abonos', $factura->id_factura);
            }

            $ultimoAbono = AbonosController::UltimoAbono($factura->id_factura);

            $nuevoSaldo = $ultimoAbono
                ? $ultimoAbono->saldo_factura - $validatedData['valor_abono']
                : $saldoInicial - $validatedData['valor_abono'];

            if ($nuevoSaldo < 0) {
                flash()->error('El valor del abono excede el saldo de la factura.');
                DB::rollBack();
                return redirect()->route('abonos', $factura->id_factura);
            }
            Abonos::create([
                'factura_id' => $validatedData['factura_id'],
                'total_factura' => $factura->Total,
                'valor_abono' => $validatedData['valor_abono'],
                'saldo_factura' => $nuevoSaldo,
                'fecha_abonado' => $validatedData['fecha_abonado'],
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha registrado un abono",
                "Factura Nro: " . $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial
            );

            $factura->update(['Estado' => $nuevoSaldo == 0 ? 1 : 3]);

            if ($nuevoSaldo == 0) {
                flash('Factura pagada con éxito!');
                DB::commit();
                return redirect()->route('cuentas');
            }

            flash('Abono registrado correctamente!');
            DB::commit();
            return redirect()->route('abonos', $factura->id_factura);
        } catch (Exception $e) {
            // Manejo de errores generales
            DB::rollBack();
            Log::error('Error al registrar el abono', ['exception' => $e]);
            flash()->error('Hubo un problema al procesar tu solicitud. Por favor, inténtalo de nuevo.');
            return redirect()->route('abonos', $request->factura_id);
        }
    }
    /**
     * Display a listing of the FileType.
     *
     * @param int $id_factura
     * @param AbonosDataTable $abonosDataTable
     * @return Response
     */
    public function edit(int $id_factura, AbonosDataTable $abonosDataTable)
    {
        try {
            $Factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($id_factura);
            $abonosDataTable->setFacturaId($id_factura);

            return $abonosDataTable->render('pages.facturas.cuentas_por_cobrar.abonos.index', compact('Factura'));
        } catch (ModelNotFoundException $e) {
            // Manejo específico para cuando no se encuentra la factura
            Log::error('Factura no encontrada', ['id' => $id_factura, 'exception' => $e]);
            flash()->error('No se pudo encontrar la factura solicitada.');
            return redirect()->route('pages.facturas.index');
        } catch (Exception $e) {
            // Manejo general para cualquier otro error
            Log::error('Error al cargar los abonos', ['id' => $id_factura, 'exception' => $e]);
            flash()->error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('pages.facturas.index');
        }
    }

    static public function UltimoAbono($id_factura)
    {
        try {

            if (!is_numeric($id_factura) || $id_factura <= 0) {
                throw new InvalidArgumentException('ID de factura inválido.');
            }

            $ultimoAbono = Abonos::where('factura_id', $id_factura)
                ->orderBy('fecha_abonado', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            return $ultimoAbono;
        } catch (Exception $e) {
            // Manejo general para cualquier otro error
            Log::error('Error al obtener el último abono', ['id_factura' => $id_factura, 'exception' => $e]);
            return redirect()->back();
        }
    }
}
