@extends('layouts.master')
@section('title')
    Establecimiento
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Establecimiento</h1>
        <h1 class="pull-right">
            @can('crear establecimiento')
                <a class="btn btn-primary pull-right mx-2" href="{{ route('crear-establecimiento') }}">
                    <i class="fa fa-plus"></i>
                    Nuevo establecimiento
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
