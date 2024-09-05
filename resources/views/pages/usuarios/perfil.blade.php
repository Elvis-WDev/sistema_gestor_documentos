@extends('layouts.master')
@section('title')
    Perfil de usuario
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Perfil de usuario
        </h1>
    </section>

    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="box-body">

                            <input name="id" type="hidden" value="{{ Auth::user()->id }}">

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="row">

                                        <!-- Foto Perfil Field -->
                                        <div class="form-group col-sm-12 text-center">
                                            <img src="{{ Auth::user()->url_img == '' ? asset('images/Default_user.png') : route('download', ['path' => Auth::user()->url_img]) }}"
                                                class="img-circle" alt="..."
                                                width="{{ Auth::user()->url_img == '' ? '200px' : '180px' }}">
                                        </div>

                                        <!-- Archivos Field -->
                                        <div class="form-group col-sm-12">
                                            <div class="fileList" id="fileList"></div>
                                        </div>
                                        <div class="form-group col-sm-12">

                                            <div class="dropzone" id="dropzone">
                                                <div class="fileList" id="fileList"></div>
                                                <i class="far fa-copy icon"></i></br></br>
                                                Arrastra y suelta archivos aquí o haz clic para seleccionar archivos
                                                <input type="file" id="image" class="Archivos fileInput"
                                                    name="image">
                                            </div>

                                        </div>


                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <!-- Nombres Field -->
                                        <div class="form-group col-sm-12 {{ $errors->has('Nombres') ? 'has-error' : '' }}">
                                            <label for="Nombres">Nombres:</label>
                                            <input class="form-control" name="Nombres" type="text" id="Nombres"
                                                value="{{ Auth::user()->Nombres }}">
                                        </div>

                                        <!-- Apellidos Field -->
                                        <div
                                            class="form-group col-sm-12 {{ $errors->has('Apellidos') ? 'has-error' : '' }}">
                                            <label for="Apellidos">Apellidos:</label>
                                            <input class="form-control" name="Apellidos" type="text" id="Apellidos"
                                                value="{{ Auth::user()->Apellidos }}">
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-group col-sm-12 {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label for="email">Email:</label>
                                            <input class="form-control" name="email" type="email" id="email"
                                                value="{{ Auth::user()->email }}">
                                        </div>

                                        <!-- Password Field -->
                                        <div
                                            class="form-group col-sm-12 {{ $errors->has('password') ? 'has-error' : '' }}">
                                            <label for="password">Contraseña:</label>
                                            <input class="form-control" name="password" type="password" id="password">

                                        </div>

                                        <!-- NombreUsuario Field -->
                                        <div class="form-group col-sm-12">
                                            <label for="NombreUsuario">Nombre de usuario:</label>
                                            <input class="form-control" name="NombreUsuario" type="text"
                                                id="NombreUsuario" value="{{ Auth::user()->NombreUsuario }}" readonly>
                                        </div>
                                    </div>
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
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
