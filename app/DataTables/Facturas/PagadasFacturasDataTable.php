<?php

namespace App\DataTables\Facturas;

use App\Models\Establecimiento;
use App\Models\Factura;
use App\Models\PagadasFactura;
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

class PagadasFacturasDataTable extends DataTable
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

                $ButtonGroup = "";

                if (Auth::user()->can('modificar facturas')) {

                    $ButtonGroup .= '
                    <a href="' . route('editar-factura', $query->id_factura) . '" class="btn btn-default btn-sm">
                     <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    <a href="' . route('anular-factura', $query->id_factura) . '" class="btn btn-danger btn-sm delete-item" message="Anular factura?">
                    <i class="fas fa-ban"></i>
                    </a>
                ';
                }
                if (Auth::user()->can('eliminar facturas')) {
                    $ButtonGroup .= '
                  <a href="' . route('destroy-factura', $query->id_factura) . '" class="btn btn-danger btn-sm delete-item" message="Eliminar factura?">
                <i class="fas fa-trash-alt"></i>
                </a>
                ';
                }

                return '
                <div class="btn-group">
                        ' . $ButtonGroup == "" ? 'No permitido' : $ButtonGroup . '
                </div>
                ';
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
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->editColumn('Total', function ($row) {
                return '<strong>$ ' . $row->Total . '</strong>';
            })
            ->editColumn('FechaEmision', function ($row) {
                return Carbon::parse($row->FechaEmision)->translatedFormat('Y-m-d H:i');
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->rawColumns(['Estado', 'action', 'Archivos', 'Total'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        return $model->where('Estado', 'Pagada')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pagadasfacturas-table')
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
                Button::make('reload')
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
            Column::make('Archivos')->title('Archivos')->addClass('text-center'),
            Column::make('RazonSocial')->title('Raz. social'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('establecimiento_id')->title('Establec.'),
            Column::make('punto_emision_id')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('Total')->title('Total'),
            Column::computed('Estado')->title('Estado')->addClass('text-center'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->printable(false)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PagadasFacturas_' . date('YmdHis');
    }
}
