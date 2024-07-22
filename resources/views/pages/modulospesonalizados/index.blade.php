@extends('layouts.master')
@section('title')
    DigiDocs || Carpetas
@endsection


@section('content')
    <style type="text/css">
        .bg-folder-shaper {
            width: 100%;
            height: 115px;
            border-radius: 0px 15px 15px 15px !Important;
        }

        .folder-shape-top {
            width: 57px;
            height: 17px;
            border-radius: 20px 37px 0px 0px;
            position: absolute;
            top: -16px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .widget-user-2 .widget-user-username,
        .widget-user-2 .widget-user-desc {
            margin-left: 10px;
            font-weight: 400;
            font-size: 17px;
        }

        .widget-user-username {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .m-t-20 {
            margin-top: 20px;
        }

        .dropdown-menu {
            min-width: 100%;
        }

        .doc-box.box {
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.0) !important;
        }

        .bg-folder-shaper:hover {
            background-color: yellow;
        }

        .select2-container {
            width: 100% !important;
        }

        #filterForm.in,
        filterForm.collapsing {
            display: block !important;
        }
    </style>
    <section class="content-header">
        <h1 class="pull-left">
            Carpetas
        </h1>
        <h1 class="pull-right">
            <a href="{{ route('crear-custom-module') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Nueva carpeta
            </a>
        </h1>
    </section>
    <div class="content" style="margin-top: 22px;">
        <div class="clearfix"></div>


        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @php
                        $Modulo = \App\Models\ModuloPersonalizado::where('Estado', 'Activo')->get();
                    @endphp
                    @foreach ($Modulo as $modulo)
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 m-t-20" style="cursor:pointer;">
                            <div class="doc-box box box-widget widget-user-2">
                                <div class="widget-user-header bg-gray bg-folder-shaper no-padding">
                                    <div class="folder-shape-top bg-gray"></div>
                                    <div class="box-header">
                                        <a href="{{ route('carpeta', $modulo->id_modulo) }}" style="color: black;">
                                            <h3 class="box-title"><i class="fa fa-folder text-yellow"></i></h3>
                                        </a>

                                        <div class="box-tools pull-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                    data-toggle="dropdown" aria-expanded="false"
                                                    style="    background: transparent;border: none;">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                                    <li><a href="{{ route('carpeta', $modulo->id_modulo) }}">Ver</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ route('edit-custom_module', $modulo->id_modulo) }}">Editar</a>
                                                    </li>
                                                    <li>
                                                        <a class="btn_eliminar_module"
                                                            id="{{ $modulo->id_modulo }}">Eliminar</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.widget-user-image -->
                                    <a href="{{ route('carpeta', $modulo->id_modulo) }}" style="color: black;">
                                        {{-- <span style="max-lines: 1; white-space: nowrap;margin-left: 3px;">
                                            <small class="label"
                                                style="background-color: #000000;font-size: 0.93rem;">Test</small>
                                        </span> --}}
                                        <h5 class="widget-user-username" title="" data-toggle="tooltip"
                                            data-original-title="Carpeta">{{ $modulo->NombreModulo }}</h5>
                                        <h5 class="widget-user-desc" style="font-size: 12px"><span data-toggle="tooltip"
                                                title=""
                                                data-original-title="12/06/2024 02:08 AM">{{ $modulo->created_at }}</span>
                                            {{-- <span class="pull-right" style="margin-right: 15px;">
                                                <i title="" data-toggle="tooltip" class="fa fa-remove"
                                                    style="color: #f44336;" data-original-title="Unverified"></i>
                                            </span> --}}
                                        </h5>
                                    </a>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                    @endforeach

                </div>
                @if ($Modulo->isEmpty())
                    <div class="alert alert-info alert-dismissible">
                        <h4><i class="icon fa fa-info"></i>No existen carpetas</h4>
                        Crea una nueva carpeta
                    </div>
                @endif
            </div>
            <div class="box-footer">

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $('.btn_eliminar_module').click(function(e) {
            // Stop the form submitting
            let id_module = $(this).attr('id');

            Swal.fire({
                title: "Eliminar carpeta?",
                text: "No podrás revertirlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#42A5F5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ route('change-status-custom_module') }}",
                        data: {
                            id_module: id_module
                        },
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
                } else if (result.isDenied) {

                }
            });

        });
    </script>
@endpush
