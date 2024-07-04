@extends('layouts.master')
@section('title')
    DigiDocs || Crear usuario
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Usuarios
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear usuarios</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('store-usuario') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <!-- Nombres Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Nombres') ? 'has-error' : '' }}">
                                    <label for="Nombres">Nombres:</label>
                                    <input class="form-control" name="Nombres" type="text" id="Nombres"
                                        value="{{ old('Nombres') }}">
                                </div>

                                <!-- Apellidos Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Apellidos') ? 'has-error' : '' }}">
                                    <label for="Apellidos">Apellidos:</label>
                                    <input class="form-control" name="Apellidos" type="text" id="Apellidos"
                                        value="{{ old('Apellidos') }}">
                                </div>

                                <!-- NombreUsuario Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('NombreUsuario') ? 'has-error' : '' }}">
                                    <label for="NombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control" name="NombreUsuario" type="text" id="NombreUsuario"
                                        value="{{ old('NombreUsuario') }}">
                                </div>

                                <!-- Email Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email:</label>
                                    <input class="form-control" name="email" type="email" id="email"
                                        value="{{ old('email') }}">
                                </div>

                                <!-- Password Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password">Contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password"
                                        value="{{ old('password') }}">
                                </div>

                                <!-- Password confirmation Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password_confirmation">Confirmar contraseña:</label>
                                    <input class="form-control" name="password_confirmation" type="text"
                                        id="password_confirmation" value="{{ old('password') }}">
                                </div>

                                <!-- Roles Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('id_rol') ? 'has-error' : '' }}">
                                    <label for="id_rol">Rol:</label>
                                    <select class="form-control id_rol" id="id_rol" name="id_rol">
                                        @php
                                            $Roles = \Spatie\Permission\Models\Role::all();
                                        @endphp

                                        @foreach ($Roles as $Rol)
                                            <option value="{{ $Rol->id }}">
                                                {{ $Rol->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <!-- Image confirmation Field -->
                                {{-- <div class="form-group col-sm-6 {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label for="image">Foto de perfil:</label>
                                    <input class="form-control" name="image" type="file" id="image">
                                </div> --}}
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

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="form-submit">Crear</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->




            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            $('#create-user-form').on('submit', function(e) {
                e.preventDefault();
                let data = $(this).serialize();
                $.ajax({
                    url: "{{ route('store-usuario') }}",
                    method: 'POST',
                    data: data,
                    beforeSend: function() {
                        $('#form-submit').text('Creando..');
                        $('#form-submit').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            alert(data.message)
                            $('#create-user-form')[0].reset();
                            $('#form-submit').text('Crear')
                            $('#form-submit').attr('disabled', false);
                        }
                    },
                    error: function(data) {
                        let errors = data.responseJSON.errors;

                        $.each(errors, function(key, value) {

                        })

                        $('#form-submit').text('Crear');
                        $('#form-submit').attr('disabled', false);
                    }
                })
            })
        })
    </script>
@endpush --}}
