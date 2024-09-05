<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="{{ asset('images/GS1-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lte/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lte/skins/skin-blue-light.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/icheck/skins/all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-wysihtml5/css/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/digidocu-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/responsive.bootstrap.css') }}">
    {{-- MorrisChart.js --}}
    <link rel="stylesheet" href="{{ asset('vendor/morrisjs/morris.css') }}">

    @yield('css')

    <style>
        /* Ajustar el tamaño y la posición del ícono */
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control::before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control::before {
            content: "\f0d7";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 5px;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
            text-align: center;
            margin-top: 6px
        }

        /* Asegurar que el botón esté centrado en la celda */
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control {
            text-align: center;
            vertical-align: middle;
        }

        /* Ajustar el espaciado en dispositivos móviles */
        @media (max-width: 767px) {
            table.dataTable.dtr-inline {
                font-size: 16px;
            }
        }
    </style>




</head>

<body class="skin-blue-light sidebar-mini">

    <div class="wrapper">
        <!-- Main Header -->
        @include('layouts.header')
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('vendor/icheck/js/icheck.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-typeahead/js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-wysihtml5/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
    {{-- SweetAlert --}}
    <script src="{{ asset('vendor/sweetalert/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('vendor/handlebars/js/handlebars.min.js') }}"></script>
    <script src="{{ asset('js/handlebar-helpers.js') }}"></script>
    <script src="{{ asset('js/digidocu-custom.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/js/es.js') }}"></script>
    {{-- Tooltip --}}
    <script src="{{ asset('vendor/tooltip/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/tooltip/tippy-bundle.umd.js') }}"></script>

    {{-- MorrisChart.js --}}
    <script src="{{ asset('vendor/morrisjs/js/raphael-min.js') }}"></script>
    <script src="{{ asset('vendor/morrisjs/js/morris.min.js') }}"></script>

    {{-- InputMask.js --}}
    <script src="{{ asset('vendor/inputmask/js/jquery.inputmask.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.delete-item', function(event) {
            event.preventDefault();

            let deleteUrl = $(this).attr('href');
            let message = $(this).attr('message');

            Swal.fire({
                title: message ? message : "Eliminar fila?",
                text: "No podrás revertirlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#42A5F5',
                cancelButtonColor: '#d33',
                confirmButtonText: message ? 'Sí, anular!' : 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,

                        success: function(data) {

                            if (data.status == 'success') {
                                window.location.reload();
                                Swal.fire({
                                    icon: "success",
                                    title: `${message ? 'Anulada' : 'Eliminado'} correctamente`,

                                })
                            } else if (data.status == 'error') {
                                Swal.fire({
                                    icon: "error",
                                    title: "No se ha podido eiminar",
                                    text: data.message,
                                    confirmButtonColor: '#42A5F5',

                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    })
                }
            }).catch(error => {});
        })
    </script>
    <script>
        $(function() {


            let currentDate = new Date();

            // Obtener los componentes de la fecha y hora actual
            let year = currentDate.getFullYear();
            let month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
            let day = String(currentDate.getDate()).padStart(2, '0');
            let hours = String(currentDate.getHours()).padStart(2, '0');
            let minutes = String(currentDate.getMinutes()).padStart(2, '0');

            // Formatear la fecha y hora actual a "Y-m-d H:i"
            let formattedDate = `${year}-${month}-${day} ${hours}:${minutes}`;

            // Select
            $('.select2').select2();

            // FlatPickerDate

            $("#FechaEmisionCreate").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                defaultDate: formattedDate,
            });

            $("#FechaEmisionEdit").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
            });

            $("#FechaPagoCreate").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                defaultDate: formattedDate,
            });
            $("#FechaPagoUpdate").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
            });
            $("#FechaSolicitudCreate").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                defaultDate: formattedDate,
            });
            $("#FechaSolicitudUpdate").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
            });

            $(".created_at").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                defaultDate: formattedDate
            });

            $(".updated_at").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
            });

            $(".reporte_daterange_fechaInicio").flatpickr({
                locale: "es",
                maxDate: "today",
                dateFormat: "Y-m-d",
            });

            $(".reporte_daterange_fechaFinal").flatpickr({
                locale: "es",
                maxDate: "today",
                dateFormat: "Y-m-d",
            });

            $(".fecha_abonado").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                defaultDate: formattedDate
            });

            // Tootltip
            tippy('[data-tippy-content]', {
                placement: 'top',
                animation: 'fade',
            });




        })
    </script>

    @yield('scripts')


    @stack('scripts')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php
                notyf()->error($error);
            @endphp
        @endforeach
    @endif

    <script>
        function initializeTippy() {
            tippy('[data-tippy-content]', {
                placement: 'top',
                animation: 'fade',
            });
        }

        $(document).ready(function() {
            // Inicializa Tippy después de que la tabla se haya inicializado por primera vez
            initializeTippy();
        });
    </script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
</body>

</html>
