@extends('layouts.master')
@section('title')
    DigiDocs || Notas de crédito
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Notas de crédito</h1>
        <h1 class="pull-right">
            @can('crear NotasCredito')
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px"
                    href="{{ route('crear-notas-credito') }}">
                    <i class="fa fa-plus"></i>
                    Nueva nota crédito
                </a>
            @endcan
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
