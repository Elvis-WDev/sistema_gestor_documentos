@extends('layouts.master')
@section('title')
    DigiDocs || Archivos
@endsection
@section('content')
    <div id="modal-space">
    </div>
    <section class="content-header" style="margin-bottom: 27px;">
        <h1 class="pull-left">
            Documentos
        </h1>
        {{-- <h1 class="pull-right" style="margin-bottom: 5px;">
            <div class="dropdown" style="display: inline-block">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i
                        class="fa fa-download"></i> Download Zip
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">All</a>
                    </li>
                    <li>
                        <a href="#">Original</a>
                    </li>
                    <li>
                        <a href="#">Varientw (Images Only)</a>
                    </li>
                </ul>
            </div>
            <a href="#" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
            <form action="#" method="delete" style="display:inline;">
                <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>
            </form>
        </h1> --}}
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nombre de carpeta:</label>
                            <p>{{ $Carpeta->NombreModulo }}</p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <span class="label label-success">Activa</span>
                        </div>
                        <div class="form-group">
                            <label>Creado por:</label>
                            @php
                                $user = \App\Models\User::findOrFail($Carpeta->id_usuario);
                                echo $user->NombreUsuario;
                            @endphp
                        </div>
                        <div class="form-group">
                            <label>Fecha creación:</label>
                            <p>{{ $Carpeta->created_at . ' ' }}<small>{{ TiempoTranscurrido($Carpeta->created_at) }}</small>
                            </p>

                        </div>
                        <div class="form-group">
                            <label>Última modificación:</label>
                            <p>{{ $Carpeta->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_files" data-toggle="tab" aria-expanded="true">Archivos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_files">
                            <div class="row">
                                @php
                                    $archivos = \App\Models\ArchivoModuloPersonalizado::where(
                                        'id_modulo',
                                        $Carpeta->id_modulo,
                                    )
                                        ->where('Estado', 'Activo')
                                        ->get();
                                @endphp
                                @foreach ($archivos as $file)
                                    <div class="col-xs-6 col-md-6 col-lg-4">
                                        <div class="box custom-box">
                                            <div class="box-body" style="display:flex;justify-content:center">
                                                @if ($file->extension == 'pdf')
                                                    <img style="cursor:pointer;height:60px;object-fit:contain;width:100%"
                                                        src="{{ asset('images/icon_pdf.svg') }}" alt=""
                                                        onclick="showFileModal({
                                                            url: '{{ asset('storage/' . $file->Archivo) }}',
                                                            extension: '{{ $file->extension }}',
                                                            name: '{{ $file->Nombre }}',
                                                            created_at: '{{ $file->created_at }}',
                                                            uploaded_by: '{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}'
                                                        })">
                                                @elseif ($file->extension == 'doc' || $file->extension == 'docx')
                                                    <img style="cursor:pointer;height:60px;object-fit:contain;width:100%"
                                                        src="{{ asset('images/icon_word.png') }}" alt=""
                                                        onclick="showFileModal({
                                                            url: '{{ asset('storage/' . $file->Archivo) }}',
                                                            extension: '{{ $file->extension }}',
                                                            name: '{{ $file->Nombre }}',
                                                            created_at: '{{ $file->created_at }}',
                                                            uploaded_by: '{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}'
                                                        })">
                                                @elseif ($file->extension == 'xlsx' || $file->extension == 'xls')
                                                    <img style="cursor:pointer;height:60px;object-fit:contain;width:100%"
                                                        src="{{ asset('images/icon_excel.webp') }}" alt=""
                                                        onclick="showFileModal({
                                                            url: '{{ asset('storage/' . $file->Archivo) }}',
                                                            extension: '{{ $file->extension }}',
                                                            name: '{{ $file->Nombre }}',
                                                            created_at: '{{ $file->created_at }}',
                                                            uploaded_by: '{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}'
                                                        })">
                                                @else
                                                    <img style="cursor:pointer;height:60px;object-fit:contain;width:100%"
                                                        src="{{ asset('storage/' . $file->Archivo) }}" alt=""
                                                        onclick="showFileModal({
                                                            url: '{{ asset('storage/' . $file->Archivo) }}',
                                                            extension: '{{ $file->extension }}',
                                                            name: '{{ $file->Nombre }}',
                                                            created_at: '{{ $file->created_at }}',
                                                            uploaded_by: '{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}'
                                                        })">
                                                @endif
                                            </div>
                                            <div class="box-header">
                                                <div class="user-block">
                                                    <span class="label label-default"> {{ $file->extension }}</span>
                                                    <span class="username"
                                                        style="cursor:pointer;">{{ $file->Nombre }}</span>
                                                    <small class="description text-gray">
                                                        <b>{{ TiempoTranscurrido($file->created_at) }}</b> Por:
                                                        <b>{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}</b>
                                                    </small>
                                                </div>
                                                <div class="pull-right box-tools">
                                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"
                                                        style="background: transparent;border: none;">
                                                        <i class="fas fa-ellipsis-v" style="color: #000;"></i>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="javascript:void(0);"
                                                                onclick="showFileModal({
                                                            url: '{{ asset('storage/' . $file->Archivo) }}',
                                                            extension: '{{ $file->extension }}',
                                                            name: '{{ $file->Nombre }}',
                                                            created_at: '{{ $file->created_at }}',
                                                            uploaded_by: '{{ \App\Models\User::findOrFail($file->id_usuario)->NombreUsuario }}'
                                                        })">
                                                                Detalles
                                                            </a></li>
                                                        <li><a href="{{ asset('storage/' . $file->Archivo) }}"
                                                                taget="blank_" download>Descargar</a>
                                                        </li>
                                                        <li>
                                                            <a class="btn_eliminar_archivo"
                                                                id="{{ $file->id_archivo }}">Eliminar</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('subir-archivo', $Carpeta->id_modulo) }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Nuevo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.scaleflex.it/plugins/filerobot-image-editor/3/filerobot-image-editor.min.js"></script>
    <script id="file-modal-template" type="text/x-handlebars-template">
        <div id="fileModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@{{ name }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a href="@{{ url }}" download class="btn btn-primary"><i class="fa fa-download"></i> Descargar</a>
                            </div>
                            <div class="form-group">
                                <label>Extención:</label>
                                <p>@{{ extension }}</p>
                            </div>
                            <div class="form-group">
                                <label>Subido por:</label>
                                <p>@{{ uploaded_by }}</p>
                            </div>
                            <div class="form-group">
                                <label>Fecha de Subida:</label>
                                <p>@{{ created_at }}</p>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="file-modal-preview">
                                <object class="obj-file-box"
                                    data="@{{ url }}" width="100%" height="600px">
                                </object>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script>
        function showFileModal(data) {
            var source = document.getElementById("file-modal-template").innerHTML;
            var template = Handlebars.compile(source);
            var html = template(data);
            document.getElementById("modal-space").innerHTML = html;
            $('#fileModal').modal('show');
        }

        $('.btn_eliminar_archivo').click(function(e) {
            // Stop the form submitting
            let id_archivo = $(this).attr('id');

            Swal.fire({
                title: "Eliminar archivo?",
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
                        url: "{{ route('change-status-archivo') }}",
                        data: {
                            id_archivo: id_archivo
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
