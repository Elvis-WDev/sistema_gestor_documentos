<?php

namespace App\DataTables;

use App\Models\Establecimiento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EstablecimientosDataTable extends DataTable
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
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($query) {
                $ButtonGroup = "";

                if (Auth::user()->can('modificar establecimiento')) {

                    $ButtonGroup .= '<a href="' . route('editar-establecimiento', $query->id) . '" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>';
                }
                if (Auth::user()->can('eliminar establecimiento')) {
                    $ButtonGroup .= '<a href="' . route('destroy-establecimiento', $query->id) . '" class="btn btn-danger btn-sm delete-item"><i class="fas fa-trash-alt"></i></a>';
                }

                if ($ButtonGroup == "") {
                    return "No permitido";
                } else {
                    return '<div class="btn-group">'  . $ButtonGroup . '</div>';
                }
            })
            ->rawColumns(['action'])
            ->setRowId('id');;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Establecimiento $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('establecimientos-table')
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
            Column::make('nombre')->title('Nombre'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->exportable(false)->printable(false)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Establecimientos_' . date('YmdHis');
    }
}
