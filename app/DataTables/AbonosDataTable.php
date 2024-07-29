<?php

namespace App\DataTables;

use App\Models\Abonos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AbonosDataTable extends DataTable
{
    protected $id_factura;

    public function setFacturaId($id_factura)
    {
        $this->id_factura = $id_factura;
    }

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
            ->editColumn('valor_abono', function ($row) {
                return '<strong>$ ' . $row->valor_abono . '</strong>';
            })
            ->editColumn('saldo_factura', function ($row) {
                return '<strong>$ ' . $row->saldo_factura . '</strong>';
            })
            ->editColumn('fecha_abonado', function ($row) {
                return Carbon::parse($row->fecha_abonado)->translatedFormat('Y-m-d H:i');
            })
            ->rawColumns(['action', 'valor_abono', 'saldo_factura', 'numero'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Abonos $model): QueryBuilder
    {
        return $model->newQuery()->where('factura_id', $this->id_factura);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('abonos-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('fila')->title('#'),
            Column::make('valor_abono')->title('Abono'),
            Column::make('saldo_factura')->title('Saldo'),
            Column::make('fecha_abonado')->title('Fecha'),
        ];
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Abonos_' . date('YmdHis');
    }
}
