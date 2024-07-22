@extends('layouts.master')
@section('title')
    DigiDocs || Cuentas por cobrar
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left"> Cuentas por cobrar</h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <form method="post" action="{{ route('generar-reporte') }}" formtarget="_blank" target="_blank">
                    @csrf
                    <div class="row">

                        <!-- reporte_inicio Field -->
                        <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                            <input class="form-control reporte_daterange_fechaInicio" name="txt_fecha_reporte_inicio"
                                type="text" id="reporte_daterange_fechaInicio" placeholder="Fecha inicio">
                        </div>

                        <!-- reporte_final Field -->
                        <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                            <input class="form-control reporte_daterange_fechaFinal" name="txt_fecha_reporte_final"
                                type="text" id="reporte_daterange_fechaFinal" placeholder="Fecha final">
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                            <button type="submit" class="btn btn-success btn-md w-100">
                                Reporte general
                            </button>
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
