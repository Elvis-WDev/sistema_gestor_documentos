@extends('layouts.master')
@section('title')
    DigiDocs || Facturas
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Facturas</h1>
        <h1 class="pull-right">

            @can('crear facturas')
                <a class="btn btn-primary pull-right mx-2" style="margin-top: -10px;margin-bottom: 5px"
                    href="{{ route('crear-factura') }}">
                    <i class="fa fa-plus"></i>
                    Nueva factura
                </a>
            @endcan

            <button type="button" class="btn btn-primary pull-right"
                style="margin-top: -10px;margin-bottom: 5px;margin-right:10px" id="reporte_daterange">
                <i class="fa fa-plus"></i>
                Reportes por fecha
            </button>

        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        {{-- @include('flash::message') --}}

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
    <div class="text-center">

    </div>
</div>
@endsection
