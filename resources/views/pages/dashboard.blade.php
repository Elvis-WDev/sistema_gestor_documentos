@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Dashboard</h1>
    </section>
    <section class="content" style="margin-top: 20px;">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        @can('dashboard')
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $Data['CantidadFacturas'] }}</h3>
                            <p>Facturas</p>
                        </div>
                        <div class="icon">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <a href="{{ route('facturas') }}" class="small-box-footer">Más info <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">

                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $Data['CantidadPagos'] }}</h3>
                            <p>Pagos</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <a href="{{ route('pagos') }}" class="small-box-footer">Más info <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">

                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $Data['CantidadSolicitudAfiliados'] }}</h3>
                            <p>Solicitud afiliados</p>
                        </div>
                        <div class="icon">
                            <i class="fa-brands fa-creative-commons-share"></i>
                        </div>
                        <a href="{{ route('solicitud-afiliados') }}" class="small-box-footer">Más info <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">

                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $Data['CantidadUsuarios'] }}</h3>
                            <p>Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-user-circle"></i>
                        </div>
                        <a href="{{ route('usuarios') }}" class="small-box-footer">Más info <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endcan

        <div class="row">
            @can('dashboard')
                <div class="col-sm-6">
                    <div class="box box-default">
                        <div class="box-header no-border">
                            <h3 class="box-title">Facturas</h3>
                        </div>
                        <div class="box-body">
                            <div id="facturas-graph-donut" style="height: 200px; position: relative;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-default">
                        <div class="box-header no-border">
                            <h3 class="box-title">Total facturas</h3>
                        </div>
                        <div class="box-body">
                            <div class="chart" id="line-chart-reportes" style="height: 200px;"></div>
                        </div>
                    </div>
                </div>
            @endcan
            <div class="col-sm-12">
                <div class="box box-default">
                    <div class="box-header no-border">
                        <h3 class="box-title">Actividad reciente</h3>

                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="timeline">

                            @foreach ($Data['Actividades'] as $activity)
                                <li>
                                    <i class="fa fa-user bg-aqua" data-toggle="tooltip"
                                        title="{{ $activity->usuario->NombreUsuario }}"></i>

                                    <div class="timeline-item">
                                        <span class="time" data-toggle="tooltip" title="{{ $activity->created_at }}">
                                            <i class="fa fa-clock-o"></i>
                                            {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>

                                        <h4 class="timeline-header no-border" data-toggle="tooltip"
                                            title="{{ $activity->Detalles }}">{!! $activity->Accion !!}</h4>
                                    </div>
                                </li>
                            @endforeach
                            <li>
                                <i class="fa fa-clock-o bg-gray"><i class="far fa-clock"></i></i>
                            </li>
                        </ul>
                        <div class="text-center">
                            {{-- {!! $activities->appends(request()->all())->render() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function() {

            var colorDanger = "#F44336";
            var colorInfo = "#2196F3";
            var colorWarning = "#FF9F1C";
            var colorSuccess = "#43A047";
            Morris.Donut({
                element: 'facturas-graph-donut',
                resize: true,
                data: [{
                        label: "Pagadas",
                        value: {{ $Data['CantidadFacturasPagadas'] }},
                        color: colorSuccess
                    },
                    {
                        label: "Abonadas",
                        value: {{ $Data['CantidadFacturasAbonadas'] }},
                        color: colorWarning
                    },
                    {
                        label: "Anuladas",
                        value: {{ $Data['CantidadFacturasAnuladas'] }},
                        color: colorDanger
                    },
                    {
                        label: "Registradas",
                        value: {{ $Data['CantidadFacturasRegistradas'] }},
                        color: colorInfo
                    }
                ]
            });

            Morris.Line({
                element: 'line-chart-reportes',
                data: @json($Data['DataFacturasTotal']),
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
