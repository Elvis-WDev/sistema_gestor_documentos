@extends('layouts.master')
@section('title')
    Facturas
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Facturas</h1>
        <h1 class="pull-right">

            @can('crear facturas')
                <a class="btn btn-primary pull-right mx-2" href="{{ route('crear-factura') }}">
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
                <div class="row">
                    <div class="col-sm-6">
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

@endsection
