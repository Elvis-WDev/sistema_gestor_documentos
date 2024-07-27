@extends('layouts.master')
@section('title')
    DigiDocs || Archivo
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Archivo
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Subir Archivo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('store-archivo') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id_modulo" value="{{ $Carpeta->id_modulo }}">
                                <input type="hidden" name="id_usuario" value="{{ Auth::user()->id }}">

                                <!-- Secuencial Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Nombre') ? 'has-error' : '' }}">
                                    <label for="Nombre">Nombre del archivo:</label>
                                    <input class="form-control" name="Nombre" type="text" id="Nombre"
                                        value="{{ old('Nombre') }}">
                                </div>

                                <!-- Total Field -->
                                <div class="form-group col-sm-6">
                                    <label for="fileList">Archivos:</label></br>
                                    <div class="fileList" id="fileList"></div>

                                </div>

                                <!-- Archivos Field -->
                                <div class="form-group col-sm-12 {{ $errors->has('Archivo') ? 'has-error' : '' }}">

                                    <div class="dropzone" id="dropzone">
                                        <i class="far fa-copy icon"></i></br></br>
                                        Arrastra y suelta archivos aquí o haz clic para seleccionar archivos
                                        <input type="file" id="fileInput" class="Archivos fileInput" name="Archivo"
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
                            <button type="submit" class="btn btn-primary">Crear</button>
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
