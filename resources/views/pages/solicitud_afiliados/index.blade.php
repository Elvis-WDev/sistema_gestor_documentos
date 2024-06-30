@extends('layouts.master')
@section('title')
    DigiDocs || Solicitud de afiliados
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Solicitud de afiliados</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px"
                href="{{ route(config('rol')[Auth::user()->id_rol] . '.crear-solicitud-afiliados') }}">
                <i class="fa fa-plus"></i>
                Nuevo solicitud de afiliado
            </a>
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
