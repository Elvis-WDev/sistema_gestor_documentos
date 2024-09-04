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

class TodasFacturasDataTable extends DataTable
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
            ->addColumn('action', function ($query) {

                $ButtonGroup = "";

                if (Auth::user()->can('modificar facturas')) {

                    $ButtonGroup .= '
                    <a href="' . route('editar-factura', $query->id_factura) . '" class="btn btn-default btn-sm">
                     <i class="glyphicon glyphicon-edit"></i>
                    </a>';
                }
                if (Auth::user()->can('eliminar facturas')) {
                    $ButtonGroup .= '
                    <a href="' . route('destroy-factura', $query->id_factura) . '" class="btn btn-danger btn-sm delete-item">
                    <i class="fas fa-trash-alt"></i></a>';
                }

                return $ButtonGroup == "" ? 'No permitido' : $ButtonGroup;
            })
            ->rawColumns(['Estado', 'action', 'Archivos', 'Total', 'numero'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        // return $model->newQuery();
        return $model->newQuery()->with(['establecimiento', 'puntoEmision']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('Todasfacturas-table')
            ->columns($this->getColumns())
            ->responsive(true)
            ->minifiedAjax()
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
            Column::computed('fila')->title('#'),
            Column::make('Archivos')->title('Archivos')->printable(false)->exportable(false)->addClass('text-center'),
            Column::make('RazonSocial')->title('Raz. social'),
            Column::make('establecimiento_id')->title('Establec.'),
            Column::make('punto_emision_id')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Total')->title('Total'),
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
        return 'TodasFacturas_' . date('YmdHis');
    }
}
