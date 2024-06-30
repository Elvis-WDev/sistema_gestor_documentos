<?php

namespace App\DataTables;

use App\Models\configuraciones_generales;
use App\Models\ConfiguracionesGeneralesDatatable;
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

class ConfiguracionesGeneralesDatatables extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('tamano_maximo_permitido', '{{$tamano_maximo_permitido}} MB')
            ->editColumn('cantidad_permitidos', '{{$cantidad_permitidos}}  archivos')
            ->addColumn('action', function ($query) {
                $ButtonGroup = '
                     <div class="btn-group">
                        <a href="' . route(config('rol')[Auth::user()->id_rol] . '.editar-configuracion', $query->id) . '" class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                     </div>
                    ';

                return $ButtonGroup;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(configuraciones_generales $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('configuracionesgeneralesdatatables-table')
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

            Column::make('id')->title('#'),
            Column::make('nombre')->title('Nombre'),
            Column::make('archivos_permitidos')->title('Archivos permitidos'),
            Column::make('cantidad_permitidos')->title('Cantidad. max'),
            Column::make('tamano_maximo_permitido')->title('Tamaño. max'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::make('action')->title('Acción')->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ConfiguracionesGeneralesDatatables_' . date('YmdHis');
    }
}
