@extends('layouts.master')
@section('title')
    Cuentas por cobrar
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Cuentas por cobrar</h1>
        <h1 class="pull-right">

            @can('crear facturas')
                <a class="btn btn-primary pull-right mx-2" style="margin-top: -10px;margin-bottom: 5px"
                    href="{{ route('crear-factura') }}">
                    <i class="fa fa-plus"></i>
                    Nueva factura
                </a>
            @endcan

        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <form method="post" action="{{ route('generar-reporte') }}" formtarget="_blank" target="_blank">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="row">

                                <!-- reporte_inicio Field -->
                                <div
                                    class="form-group col-sm-4 {{ $errors->has('txt_fecha_reporte_inicio') ? 'has-error' : '' }}">
                                    <input class="form-control reporte_daterange_fechaInicio"
                                        name="txt_fecha_reporte_inicio" type="text" id="reporte_daterange_fechaInicio"
                                        placeholder="Fecha inicio">
                                </div>

                                <!-- reporte_final Field -->
                                <div
                                    class="form-group col-sm-4 {{ $errors->has('txt_fecha_reporte_final') ? 'has-error' : '' }}">
                                    <input class="form-control reporte_daterange_fechaFinal" name="txt_fecha_reporte_final"
                                        type="text" id="reporte_daterange_fechaFinal" placeholder="Fecha final">
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group col-sm-4">
                                    <button type="submit" class="btn btn-success btn-md w-100">
                                        Reporte general
                                    </button>
                                </div>

                            </div>

                        </div>
                        <div class="col-sm-6 text-right">

                            <div class="btn-group">
                                <a href="{{ route('facturas') }}" type="button" class="btn btn-xs btn-info">Facturas</a>
                                <a href="{{ route('cuentas') }}" type="button" class="btn btn-xs btn-primary">Cuentas</a>
                                <a href="{{ route('facturas-pagadas') }}" type="button"
                                    class="btn btn-xs btn-success">Pagadas</a>
                                <a href="{{ route('facturas-abonadas') }}" type="button"
                                    class="btn btn-xs btn-warning">Abonadas</a>
                                <a href="{{ route('facturas-anuladas') }}" type="button"
                                    class="btn btn-xs btn-danger">Anuladas</a>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
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
    <div class="text-center">

    </div>
</div>
@endsection
