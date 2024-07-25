<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>
        @yield('title')
    </title>
    <link rel="shortcut icon" href="{{ asset('images/GS1-logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/lte/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lte/skins/skin-blue-light.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-wysihtml5/css/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/digidocu-custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    {{-- MorrisChart.js --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">


    @yield('css')
</head>

<body class="skin-blue-light sidebar-mini">

    {{-- @if (!Auth::guest()) --}}
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
    {{-- @else --}}
    {{-- <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{!! url('/') !!}">
                        InfyOm Generator
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{!! url('/home') !!}">Home</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li><a href="{!! url('/login') !!}">Login</a></li>
                        <li><a href="{!! url('/register') !!}">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('vendor/bootstrap-typeahead/js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-wysihtml5/js/bootstrap3-wysihtml5.all.min.js') }}"></script>
    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.4.2/handlebars.min.js"></script>
    <script src="{{ asset('js/handlebar-helpers.js') }}"></script>
    <script src="{{ asset('js/digidocu-custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr@4.6.13/dist/l10n/es.js"></script>
    {{-- Tooltip --}}
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

    {{-- MorrisChart.js --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    {{-- InputMask.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"
        integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
            })
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

    <script></script>


</body>

</html>
