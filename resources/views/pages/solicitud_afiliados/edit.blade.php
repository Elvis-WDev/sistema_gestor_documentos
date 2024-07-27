@extends('layouts.master')
@section('title')
    Solicitud de afiliadoS
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Solicitud de afiliados
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar solicitud de afiliado</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('update-solicitud') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $SolicitudAfiliados->id }}">
                                <input type="hidden" name="old_archivos" value="{{ $SolicitudAfiliados->Archivos }}">

                                <!-- NombreCLiente Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('NombreCliente') ? 'has-error' : '' }}">
                                    <label for="NombreCliente">Nombre de cliente:</label>
                                    <input class="form-control" name="NombreCliente" type="text" id="NombreCliente"
                                        value="{{ $SolicitudAfiliados->NombreCliente }}">
                                </div>

                                <!-- Prefijo Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Prefijo') ? 'has-error' : '' }}">
                                    <label for="Prefijo">Prefijo:</label>
                                    <input class="form-control" name="Prefijo" type="number" id="Prefijo"
                                        value="{{ $SolicitudAfiliados->Prefijo }}">
                                </div>

                                <!-- FechaSolicitud Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('FechaSolicitud') ? 'has-error' : '' }}">
                                    <label for="FechaSolicitud">Fecha de solicitud:</label>
                                    <input class="form-control" name="FechaSolicitud" type="text"
                                        id="FechaSolicitudUpdate" value="{{ $SolicitudAfiliados->FechaSolicitud }}">
                                </div>

                                <!-- FechaSolicitud Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('updated_at') ? 'has-error' : '' }}">
                                    <label for="updated_at">Última modificación:</label>
                                    <input class="form-control" name="updated_at" type="text" id="updated_at"
                                        value="{{ $SolicitudAfiliados->updated_at }}" disabled>
                                </div>

                                <!-- Archivos Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Total">Archivos subidos:</label></br>
                                    @php
                                        $Files = json_decode($SolicitudAfiliados->Archivos);
                                    @endphp

                                    @foreach ($Files as $file)
                                        <div class="btn-group">
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                data-tippy-content="{{ substr($file, 28) }}"
                                                class="btn btn-default btn-md">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>

                                <!-- Archivos Field -->
                                <div class="form-group col-sm-12">

                                    <label for="Total">Nuevos Archivos:</label></br>
                                    <div class="fileList" id="fileList"></div>

                                </div>

                                <div class="form-group col-sm-12 {{ $errors->has('Archivos') ? 'has-error' : '' }}">

                                    <div class="dropzone" id="dropzone">
                                        <i class="far fa-copy icon"></i></br></br>
                                        Arrastra y suelta archivos aquí o haz clic para subir nuevos
                                        <input type="file" id="fileInput" class="Archivos fileInput" name="Archivos[]"
                                            multiple>
                                    </div>

                                </div>


                            </div>
                            @if ($errors->any())
                                <div class="alert alert-light">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.querySelector('.dropzone');
            const fileInput = document.querySelector('.fileInput');
            const fileList = document.querySelector('.fileList');

            dropzone.addEventListener('click', () => {
                fileInput.click();
            });

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('hover');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('hover');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('hover');
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', (e) => {
                e.preventDefault();
                handleFiles(e.target.files);
            });

            function handleFiles(files) {
                console.log(files);

                // Crear un objeto DataTransfer para manejar los archivos
                const dataTransfer = new DataTransfer();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    dataTransfer.items.add(file);
                }

                // Opcional: Mostrar los archivos en fileList
                fileList.innerHTML = ''; // Limpiar la lista antes de mostrar los archivos
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item col-sm-3';
                    fileItem.textContent = `${file.name}`;
                    fileList.appendChild(fileItem);
                }

                // Asignar los archivos al input Archivos[]
                const archivosInput = document.querySelector('.Archivos');
                archivosInput.files = dataTransfer.files;
            }
        });
    </script>
@endpush
