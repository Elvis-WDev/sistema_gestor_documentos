@extends('layouts.master')
@section('title')
    Solicitud de afiliados
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Solicitud de afiliados</h1>
        <h1 class="pull-right">
            @can('crear SolicitudAfiliado')
                <a class="btn btn-primary pull-right" href="{{ route('crear-solicitud-afiliados') }}">
                    <i class="fa fa-plus"></i>
                    Nueva solicitud
                </a>
            @endcan

        </h1>
    </section>
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
    <div class="text-center">

    </div>
</div>
@endsection
