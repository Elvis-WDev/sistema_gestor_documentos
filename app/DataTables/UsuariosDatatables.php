<?php

namespace App\DataTables;

use App\Models\Rol;
use App\Models\User;
use App\Models\UsuariosDatatable;
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

class UsuariosDatatables extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))

            ->addColumn('id_rol', function ($query) {
                // Obtener todos los roles del usuario
                $roles = $query->roles->pluck('name')->toArray();

                if (!empty($roles)) {
                    return implode(', ', $roles); // Si hay múltiples roles, se mostrarán separados por coma
                } else {
                    return 'No existe rol asociado';
                }
            })

            ->addColumn('action', function ($query) {


                $ButtonGroup = '';

                if ($query->id != 1) {
                    if (Auth::user()->can('modificar usuario')) {

                        $ButtonGroup .= ' 
                            <a href="' . route('editar-usuario', $query->id) . '" class="btn btn-default btn-sm">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        ';
                    }

                    if (Auth::user()->can('eliminar usuario')) {

                        $ButtonGroup .= ' 
                            <a href="' . route('destroy-usuario', $query->id) . '" class="btn btn-danger btn-sm delete-item">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        ';
                    }
                }

                return ' <div class="btn-group">
                           ' . $ButtonGroup == "" ? "No permitido" : $ButtonGroup . '
                        </div>';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->rawColumns(['id_rol'], ['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('usuariosdatatables-table')
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
            Column::make('NombreUsuario')->title('Nombre de usuario'),
            Column::make('email')->title('Email'),
            Column::make('id_rol')->title('Rol'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->printable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UsuariosDatatables_' . date('YmdHis');
    }
}
