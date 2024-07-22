<?php

namespace App\DataTables\Facturas;

use App\Models\Abonos;
use App\Models\AnuladasFactura;
use App\Models\Establecimiento;
use App\Models\Factura;
use App\Models\PuntoEmision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AnuladasFacturasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $count = 0;
        return (new EloquentDataTable($query))
            ->addColumn('establecimiento_id', function ($query) {
                $Establecimiento = Establecimiento::where('id', '=', $query->establecimiento_id)->first();

                if ($Establecimiento) {
                    return $Establecimiento->nombre;
                } else {
                    return 'No existe factura asociada';
                }
            })
            ->addColumn('punto_emision_id', function ($query) {
                $PuntoEmision = PuntoEmision::where('id', '=', $query->punto_emision_id)->first();

                if ($PuntoEmision) {
                    return $PuntoEmision->nombre;
                } else {
                    return 'No existe factura asociada';
                }
            })
            ->addColumn('Archivos', function ($query) {
                $archivos = json_decode($query->Archivos, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return 'Error en la decodificación JSON: ' . json_last_error_msg();
                }

                // Generar botones para cada archivo
                $buttons = '';

                foreach ($archivos as $archivo) {
                    $buttons .= '
            <a href="' . asset('storage/' . $archivo) . '" target="_blank" data-tippy-content="' . substr($archivo, 17) . '" class="btn btn-default btn-md">
                <i class="fas fa-print"></i>
            </a>';
                }

                return '
            <div class="btn-group">
            ' . $buttons . '
            </div>
            ';
            })
            ->addColumn('action', function ($query) {

                if (Auth::user()->can('modificar facturas')) {

                    $ButtonGroup = '
               
                <a href="' . route('abonos', $query->id_factura) . '" class="btn btn-info btn-sm">
                     <i class="fa-solid fa-money-bill-wave"></i>
                </a>
            ';
                } else {
                    $ButtonGroup = 'No permitido';
                }

                return $ButtonGroup;
            })
            ->addColumn('Estado', function ($query) {

                $Button = '
                <button class="btn btn-default btn-xs">
                     Desconocido
                </button>
            ';

                if ($query->Estado == 'Pagada') {
                    $Button = ' 
                <button class="btn btn-success btn-xs">
                     Pagada
                </button>';
                } elseif ($query->Estado == 'Anulada') {
                    $Button = ' 
                <button class="btn btn-danger btn-xs">
                     Anulada
                </button>';
                } elseif ($query->Estado == 'Abonada') {
                    $Button = ' 
                <button class="btn btn-warning btn-xs">
                     Abonada
                </button>';
                } elseif ($query->Estado == 'Registrada') {
                    $Button = ' 
                <button class="btn btn-info btn-xs">
                     Registrada
                </button>';
                }

                return $Button;
            })
            ->addColumn('saldo', function ($query) {
                if ($query->Estado != 'Anulada') {
                    $ultimoAbono = Abonos::where('factura_id', $query->id_factura)
                        ->orderBy('fecha_abonado', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($ultimoAbono) {
                        $saldo = $ultimoAbono->saldo_factura;
                    } else {
                        $saldo = $query->Total;
                        $saldo -= $query->RetencionIva;
                        $saldo -= $query->RetencionFuente;
                    }
                    // Asegurarse de que el saldo nunca sea negativo
                    if ($saldo < 0) {
                        $saldo = 0;
                    }

                    $saldoFormateado = '$ ' . number_format($saldo, 2);
                    return '<span style="color: #43A047;"><strong>' . $saldoFormateado . '</strong></span>';
                }
                return '<span style="color: #F44336;"><strong>' . '$ 0.00' . '</strong></span>';
            })
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->editColumn('RetencionIva', function ($row) {
                return '<strong>$ ' . $row->RetencionIva . '</strong>';
            })
            ->editColumn('RetencionFuente', function ($row) {
                return '<strong>$ ' . $row->RetencionFuente . '</strong>';
            })
            ->editColumn('Total', function ($row) {
                return '<strong>$ ' . $row->Total . '</strong>';
            })
            ->editColumn('ValorAnulado', function ($row) {
                return '<span style="color: #F44336;"><strong>$ ' . $row->ValorAnulado . '</strong></span>';
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->rawColumns(['Estado', 'action', 'Archivos', 'Total', 'RetencionIva', 'RetencionFuente', 'ValorAnulado', 'saldo'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        return $model->where('Estado', 'Anulada')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('anuladasfacturas-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->scrollX(true)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],

                ],
                'language' => [
                    'url' => url('vendor/datatables/es-ES.json')
                ],
                'initComplete' => 'function(settings, json) {
                    initializeTippy();
                }',
                'drawCallback' => 'function(settings) {
                    initializeTippy();
                }',
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('fila')->title('#'),
            // Column::make('id_factura')->title('#'),
            Column::make('Archivos')->title('Factura')->printable(false)->addClass('text-center'),
            Column::make('establecimiento_id')->title('Establec.'),
            Column::make('punto_emision_id')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('Prefijo')->title('Pref.'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Total')->title('Total fact.'),
            Column::make('RetencionIva')->title('Ret. iva'),
            Column::make('RetencionFuente')->title('Ret. fuente'),
            Column::computed('ValorAnulado')->title('Valor anulado')->addClass('text-center'),
            Column::computed('Estado')->title('Estado')->addClass('text-center'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->printable(false)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AnuladasFacturas_' . date('YmdHis');
    }
}
