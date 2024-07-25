<?php

namespace App\DataTables;

use App\Models\SolicitudAfiliados;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SolicitudAfiliadosDatatables extends DataTable
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

                $ButtonGroup = "";

                if (Auth::user()->can('modificar SolicitudAfiliado')) {

                    $ButtonGroup .= '
                <a href="' . route('editar-solicitud-afiliado', $query->id) . '" class="btn btn-default btn-sm">
                 <i class="glyphicon glyphicon-edit"></i>
                </a>
            ';
                }
                if (Auth::user()->can('eliminar pagos')) {
                    $ButtonGroup .= '
              <a href="' . route('destroy-solicitud', $query->id) . '" class="btn btn-danger btn-sm delete-item" message="Eliminar solicitud?">
            <i class="fas fa-trash-alt"></i>
            </a>
            ';
                }

                return $ButtonGroup == "" ? 'No permitido' : $ButtonGroup;
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
                    <a href="' . asset('storage/' . $archivo) . '" target="_blank" data-tippy-content="' . substr($archivo, 28) . '" class="btn btn-default btn-md">
                        <i class="fas fa-print"></i>
                    </a>';
                }

                return '
                    <div class="btn-group">
                    ' . $buttons . '
                    </div>
                    ';
            })
            ->addColumn('fila', function () use (&$count) {
                $count++;
                return $count;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('Y-m-d H:i');
            })
            ->rawColumns(['action', 'Archivos'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SolicitudAfiliados $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('SolicitudAfiliadosDatatables-table')
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
            // Column::make('id_solicitudAfiliados')->title('#'),
            Column::make('Archivos')->title('Archivos')->printable(false)->addClass('text-center'),
            Column::make('Prefijo')->title('Prefíjo'),
            Column::make('NombreCliente')->title('Nombre de cliente'),
            Column::make('FechaSolicitud')->title('Fecha de solicitud'),
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
        return 'CartasAfiliadosDatatables_' . date('YmdHis');
    }
}
