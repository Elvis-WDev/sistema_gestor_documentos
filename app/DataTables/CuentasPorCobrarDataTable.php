<?php

namespace App\DataTables;

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

class CuentasPorCobrarDataTable extends DataTable
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
            ->editColumn('ValorAnulado', function ($row) {
                return '<strong>$ ' . $row->ValorAnulado . '</strong>';
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->translatedFormat('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($query) {

                $ButtonGroup = '';

                if (Auth::user()->can('modificar facturas')) {
                    $ButtonGroup .= '<a href="' . route('editar-cuentas', $query->id_factura) . '" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-edit"></i></a>';
                }
                if (Auth::user()->can('abonar facturas')) {
                    $ButtonGroup .= '<a href="' . route('abonos', $query->id_factura) . '" class="btn btn-info btn-sm"><i class="fa-solid fa-money-bill-wave"></i></a>';
                }
                if (Auth::user()->can('anular facturas')) {
                    if ($query->Estado == "Registrada" || $query->Estado == "Abonada") {
                        $ButtonGroupAbonadaState = '<a href="' . route('anular-factura', $query->id_factura) . '" class="btn btn-danger btn-sm delete-item" message="Desea anular factura?"><i class="fas fa-ban"></i></a>';
                    } else {
                        $ButtonGroupAbonadaState = '<button class="btn btn-danger btn-sm disabled"><i class="fas fa-ban"></i></button>';
                    }
                    $ButtonGroup .=  $ButtonGroupAbonadaState;
                }

                if ($ButtonGroup == "") {
                    return "No permitido";
                } else {
                    return '<div class="btn-group">'  . $ButtonGroup . '</div>';
                }
            })
            ->rawColumns(['Estado', 'action', 'Archivos', 'Total', 'RetencionIva', 'RetencionFuente', 'ValorAnulado', 'saldo'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Factura $model): QueryBuilder
    {
        return $model->whereIn('Estado', ['Registrada', 'Abonada'])->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cuentasporcobrar-table')
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
            Column::make('Archivos')->title('Factura')->printable(false)->exportable(false)->addClass('text-center'),
            Column::make('establecimiento_id')->title('Establec.'),
            Column::make('punto_emision_id')->title('P. emisión'),
            Column::make('Secuencial')->title('Secuencial'),
            Column::make('Prefijo')->title('Pref.'),
            Column::make('FechaEmision')->title('Fec. emisión'),
            Column::make('Total')->title('Total fact.'),
            Column::computed('saldo')->title('Saldo')->addClass('text-center'),
            Column::make('RetencionIva')->title('Ret. iva'),
            Column::make('RetencionFuente')->title('Ret. fuente'),
            Column::computed('ValorAnulado')->title('Valor anulado')->addClass('text-center'),
            Column::computed('Estado')->title('Estado')->addClass('text-center'),
            Column::make('updated_at')->title('última modificación'),
            Column::computed('action')->title('Acción')->printable(false)->exportable(false)->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CuentasPorCobrar_' . date('YmdHis');
    }
}
