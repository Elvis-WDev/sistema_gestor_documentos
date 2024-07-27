<?php

namespace App\Traits;

use App\Http\Controllers\AbonosController;

trait Datatables
{

    public function DatatableArchivos($Archivos)
    {
        $archivos = json_decode($Archivos, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return 'Error en la decodificación JSON: ' . json_last_error_msg();
        }

        $buttons = '';

        foreach ($archivos as $archivo) {

            $buttons .= '<a href="' . route('download', ['path' => $archivo])  . '" target="_blank" data-tippy-content="' . substr($archivo, 17) . '" class="btn btn-default btn-md"><i class="fas fa-print"></i></a>';
        }

        return '<div class="btn-group">' . $buttons . '</div>';
    }

    public function DatatableEstado($Estado)
    {
        $Button = '
                    <button class="btn btn-default btn-xs">
                         Desconocido
                    </button>
                ';

        if ($Estado == 'Pagada') {
            $Button = ' 
                    <button class="btn btn-success btn-xs">
                         Pagada
                    </button>';
        } elseif ($Estado == 'Anulada') {
            $Button = ' 
                    <button class="btn btn-danger btn-xs">
                         Anulada
                    </button>';
        } elseif ($Estado == 'Abonada') {
            $Button = ' 
                    <button class="btn btn-warning btn-xs">
                         Abonada
                    </button>';
        } elseif ($Estado == 'Registrada') {
            $Button = ' 
                    <button class="btn btn-info btn-xs">
                         Registrada
                    </button>';
        }

        return $Button;
    }
    public function DatatableSaldo($query)
    {
        if ($query->Estado != 'Anulada') {

            $ultimoAbono = AbonosController::UltimoAbono($query->id_factura);

            if ($ultimoAbono) {
                $saldo = $ultimoAbono->saldo_factura;
            } else {
                $saldo = $query->Total;
                $saldo -= $query->RetencionIva;
                $saldo -= $query->RetencionFuente;
            }
            // Asegurarse de que el saldo nunca sea negativo
            if ($saldo < 0) {
                $saldo = 0;
            }

            $saldoFormateado = '$ ' . number_format($saldo, 2);
            return '<span style="color: #43A047;"><strong>' . $saldoFormateado . '</strong></span>';
        }
        return '<span style="color: #F44336;"><strong>' . '$ 0.00' . '</strong></span>';
    }
}
