<?php

namespace App\DataTables;

use App\Models\Factura;
use App\Models\Pago;
use App\Traits\Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PagosDataTable extends DataTable
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
            ->addColumn('id_factura', function ($query) {

                $factura = Factura::with(['establecimiento', 'puntoEmision'])->where('id_factura', '=', $query->id_factura)->first();

                return  $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial;
            })
            ->addColumn('Archivos', function ($query) {
                return $this->DatatableArchivos($query->Archivos);
            })
            ->editColumn('Total', '$ {{$Total}}')
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->addColumn('action', function ($query) {
                $ButtonGroup = "";

                if (Auth::user()->can('modificar pagos')) {

                    $ButtonGroup .= '<a href="' . route('editar-pago', $query->id_pago) . '" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>';
                }
                if (Auth::user()->can('eliminar pagos')) {
                    $ButtonGroup .= '<a href="' . route('destroy-pago', $query->id_pago) . '" class="btn btn-danger btn-sm delete-item" message="Eliminar pago?"><i class="fas fa-trash-alt"></i></a>';
                }

                return $ButtonGroup == "" ? 'No permitido' : $ButtonGroup;
            })
            ->rawColumns(['action', 'Archivos'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Pago $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pagos-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('id_factura')->title('Factura Nro.')->addClass('text-center'),
            Column::make('Archivos')->title('Archivos')->exportable(false)->printable(false)->addClass('text-center'),
            Column::make('Total')->title('Total'),
            Column::make('FechaPago')->title('Fecha del pago'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->exportable(false)->printable(false)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pagos_' . date('YmdHis');
    }
}
