<?php

namespace App\DataTables\Facturas;

use App\Models\Factura;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AbonadasFacturasDataTable extends DataTable
{
    use Datatables;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $count = 0;
        return (new EloquentDataTable($query))
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->addColumn('establecimiento_id', function ($query) {
                return $query->establecimiento->nombre;
            })
            ->addColumn('punto_emision_id', function ($query) {
                return $query->puntoEmision->nombre;
            })
            ->addColumn('Archivos', function ($query) {
                return $this->DatatableArchivos($query->Archivos);
            })
            ->addColumn('Estado', function ($query) {
                return $this->DatatableEstado($query->Estado);
            })
            ->addColumn('saldo', function ($query) {
                return $this->DatatableSaldo($query);
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
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($query) {

                if (Auth::user()->can('abonar facturas')) {

                    $ButtonGroup = '<a href="' . route('abonos', $query->id_factura) . '" class="btn btn-info btn-sm"><i class="fa-solid fa-money-bill-wave"></i></a>';
                } else {
                    $ButtonGroup = 'No permitido';
                }

                return $ButtonGroup;
            })
            ->rawColumns(['Estado', 'action', 'Archivos', 'Total', 'RetencionIva', 'RetencionFuente', 'ValorAnulado', 'saldo'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        return $model->where('Estado', 'Abonada')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('abonadasfacturas-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->responsive(true)
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
            Column::make('Archivos')->title('Archivos')->printable(false)->exportable(false)->addClass('text-center'),
            Column::make('establecimiento_id')->title('Establec.'),
            Column::make('punto_emision_id')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('Prefijo')->title('Pref.'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Total')->title('Total'),
            Column::computed('saldo')->title('Saldo')->addClass('text-center'),
            Column::computed('Estado')->title('Estado')->addClass('text-center'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->printable(false)->exportable(false)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AbonadasFacturas_' . date('YmdHis');
    }
}
