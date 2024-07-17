<?php

namespace App\DataTables;

use App\Models\NotasCredito;
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

class NotasCreditoDataTable extends DataTable
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
            ->addColumn('action', function ($query) {

                if (Auth::user()->can('modificar NotasCredito')) {

                    $ButtonGroup = '
                    <div class="btn-group">
                        <a href="' . route('editar-nota-credito', $query->id) . '" class="btn btn-default btn-sm">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                    </div>
                    ';
                } else {
                    $ButtonGroup = 'No permitido';
                }
                return $ButtonGroup;
            })
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->editColumn('Total', '$ {{$Total}}')
            ->editColumn('FechaEmision', function ($row) {
                return Carbon::parse($row->FechaEmision)->translatedFormat('Y-m-d');
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NotasCredito $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('notascredito-table')
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
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('fila')->title('#'),
            // Column::make('id')->title('#'),
            Column::make('Archivo')->title('Archivos'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Establecimiento')->title('Establec'),
            Column::make('PuntoEmision')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('RazonSocial')->title('Raz. social'),
            Column::make('Total')->title('Total'),
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
        return 'NotasCredito_' . date('YmdHis');
    }
}
