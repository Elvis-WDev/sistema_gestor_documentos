@extends('layouts.master')
@section('title')
    DigiDocs || Facturas
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Reportes de facturas</h1>
    </section>
    <div class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">

                        <i class="fas fa-chart-line"></i>

                        <h3 class="box-title">Total de facturas</h3>

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('generar-reporte') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <!-- reporte_inicio Field -->
                                <div class="form-group col-sm-2">
                                    <label for="reporte_daterange_fechaInicio">Fecha inicio:</label>
                                    <input class="form-control reporte_daterange_fechaInicio"
                                        name="txt_fecha_reporte_inicio" type="text" id="reporte_daterange_fechaInicio">

                                </div>

                                <!-- reporte_final Field -->
                                <div class="form-group col-sm-2">
                                    <label for="reporte_daterange_fechaFinal">Fecha final:</label>
                                    <input class="form-control reporte_daterange_fechaFinal" name="txt_fecha_reporte_final"
                                        type="text" id="reporte_daterange_fechaFinal">

                                </div>
                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-success btn-md">
                                        Generar
                                    </button>

                                </div>
                                <div class="col-sm-12">

                                    <div class="chart" id="line-chart-reportes" style="height: 250px;"></div>

                                </div>

                            </div>

                        </div>
                    </form>


                </div>
                <!-- /.box -->

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            new Morris.Line({
                element: 'line-chart-reportes',
                data: @json($facturas),
                xkey: 'FechaEmision',
                ykeys: ['value'],
                labels: ['Total'],
                xLabelFormat: function(x) { // Formatear las etiquetas del eje X
                    return x.toLocaleString('es-ES', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                },
                dateFormat: function(x) { // Formatear los tooltips
                    var date = new Date(x);
                    return date.toLocaleString('es-ES', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                },
                lineWidth: 3,
                hideHover: 'auto',
                gridStrokeWidth: 0.5,
                pointSize: 5,
                preUnits: '$',
                gridTextSize: 12
            });
        });
    </script>
@endpush
