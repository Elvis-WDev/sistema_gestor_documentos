<?php

namespace App\DataTables;

use App\Models\Factura;
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

class FacturasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('Estado', function ($query) {
                if (Auth::user()->can('modificar facturas')) {
                    $select = '
                    <select class="form-control" id="Estado" name="Estado">
                        <option value="1" ' . ($query->Estado == "Pagada" ? "selected" : "") . '>Pagada</option>
                        <option value="2" ' . ($query->Estado == "Anulada" ? "selected" : "") . '>Anulada</option>
                        <option value="3" ' . ($query->Estado == "Abonada" ? "selected" : "") . '>Abonada</option>
                    </select>    
                    ';
                } else {
                    $select = $query->Estado;
                }

                return $select;
            })
            ->addColumn('action', function ($query) {
                if (Auth::user()->can('modificar facturas')) {

                    $ButtonGroup = '
                    <div class="btn-group">
                    <a href="' . route('editar-factura', $query->id_factura) . '" class="btn btn-default btn-xs">
                    <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    </div>
                    ';
                } else {
                    $ButtonGroup = 'No permitido';
                }

                return $ButtonGroup;
            })
            ->editColumn('Abono', '$ {{$Abono}}')
            ->editColumn('RetencionIva', '$ {{$RetencionIva}}')
            ->editColumn('RetencionFuente', '$ {{$RetencionFuente}}')
            ->editColumn('Total', '$ {{$Total}}')
            ->editColumn('FechaEmision', function ($row) {
                return Carbon::parse($row->FechaEmision)->translatedFormat('d \d\e F \d\e Y');
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i');
            })
            ->rawColumns(['Estado', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('facturas-table')
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
            Column::make('id_factura')->title('#'),
            Column::make('Archivo')->title('Archivos'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Establecimiento')->title('Establec'),
            Column::make('PuntoEmision')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('RazonSocial')->title('Raz. social'),
            Column::make('Abono')->title('Abono'),
            Column::make('RetencionIva')->title('Ret. iva'),
            Column::make('RetencionFuente')->title('Ret. Fuente'),
            Column::make('Total')->title('Total'),
            Column::make('created_at')->title('Fecha creación'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('Estado')->title('Estado')->printable(false),
            Column::computed('action')->title('Acción')->printable(false)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Facturas_' . date('YmdHis');
    }
}
