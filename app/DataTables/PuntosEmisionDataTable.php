<?php

namespace App\DataTables;

use App\Models\Establecimiento;
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

class PuntosEmisionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('establecimiento_id', function ($query) {
                $Establecimiento = Establecimiento::where('id', '=', $query->establecimiento_id)->first();

                if ($Establecimiento) {
                    return $Establecimiento->nombre;
                } else {
                    return 'No existe establecimiento asociada';
                }
            })
            ->addColumn('action', function ($query) {


                $ButtonGroup = "";

                if (Auth::user()->can('modificar punto_emision')) {

                    $ButtonGroup .= '
                 <a href="' . route('editar-punto_emision', $query->id) . '" class="btn btn-default btn-sm">
                <i class="glyphicon glyphicon-edit"></i>
                </a>
                ';
                }
                if (Auth::user()->can('eliminar punto_emision')) {
                    $ButtonGroup .= '
                  <a href="' . route('destroy-punto_emision', $query->id) . '" class="btn btn-default btn-sm delete-item">
                <i class="fas fa-trash-alt"></i>
                </a>
                ';
                }

                return '
                <div class="btn-group">
                        ' . $ButtonGroup == "" ? 'No permitido' : $ButtonGroup . '
                </div>
                ';

                return $ButtonGroup;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PuntoEmision $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('puntosemision-table')
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
            Column::make('id')->title('#'),
            Column::make('establecimiento_id')->title('Establecimiento'),
            Column::make('nombre')->title('Punto emision'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PuntosEmision_' . date('YmdHis');
    }
}
