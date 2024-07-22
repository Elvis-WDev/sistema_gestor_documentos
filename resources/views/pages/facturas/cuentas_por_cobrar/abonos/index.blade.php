@extends('layouts.master')
@section('title')
    DigiDocs || Abonos
@endsection
@section('content')
    @php
        $saldoFormateado = 0;
        if ($Factura->Estado != 'Anulada') {
            $ultimoAbono = \App\Models\Abonos::where('factura_id', $Factura->id_factura)
                ->orderBy('fecha_abonado', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoAbono) {
                $saldo = $ultimoAbono->saldo_factura;
            } else {
                $saldo = $Factura->Total;
                $saldo -= $Factura->RetencionIva;
                $saldo -= $Factura->RetencionFuente;
            }
            if ($saldo < 0) {
                $saldo = 0;
            }

            $saldoFormateado = number_format($saldo, 2);
        }
    @endphp
    <section class="content-header">
        <h1>

            @php
                $establecimiento = \App\Models\Establecimiento::where('id', $Factura->establecimiento_id)->first();
                $puntoemision = \App\Models\PuntoEmision::where('id', $Factura->punto_emision_id)->first();
            @endphp

            Factura No. <a
                href="{{ route('editar-factura', $Factura->id_factura) }}">{{ $establecimiento->nombre }}-{{ $puntoemision->nombre }}-{{ $Factura->Secuencial }}</a>
            ({{ $Factura->Estado == 'Pagada' ? 'Pagada' : '$' . $saldoFormateado }})
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nuevo abono</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('store-abono') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="factura_id" value="{{ $Factura->id_factura }}">
                                <input type="hidden" name="total_factura" value="{{ $Factura->Total }}">

                                <div class="col-sm-12">

                                    <div class="row">
                                        <div
                                            class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 {{ $errors->has('valor_abono') ? 'has-error' : '' }}">
                                            <label for="valor_abono">Abono:</label>
                                            <input class="form-control valor_abono" name="valor_abono" type="number"
                                                id="valor_abono" min="0" value="0" step="any"
                                                {{ $Factura->Estado == 'Pagada' || $Factura->Estado == 'Anulada' ? 'disabled' : '' }}>
                                        </div>
                                        <div
                                            class="form-group col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 {{ $errors->has('fecha_abonado') ? 'has-error' : '' }}">
                                            <label for="fecha_abonado">Fecha de abono:</label>
                                            <input class="form-control fecha_abonado" name="fecha_abonado" type="text"
                                                id="fecha_abonado"
                                                {{ $Factura->Estado == 'Pagada' || $Factura->Estado == 'Anulada' ? 'disabled' : '' }}>
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                                            <label>Acción:</label>
                                            </br>
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success btn-md btn_save_abono"
                                                    {{ $Factura->Estado == 'Pagada' || $Factura->Estado == 'Anulada' ? 'disabled' : '' }}>
                                                    Registrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12">

                                    <div class="row">

                                        <div class="content">
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="box box-primary">
                                                <div class="box-body">
                                                @section('css')
                                                    @include('layouts.datatables.datatables_css')
                                                @endsection

                                                {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered table-mini']) !!}

                                                @section('scripts')
                                                    @include('layouts.datatables.datatables_js')
                                                    {!! $dataTable->scripts() !!}
                                                @endsection

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-light">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>
@endsection
