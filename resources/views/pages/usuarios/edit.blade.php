@extends('layouts.master')
@section('title')
    DigiDocs || Editar usuario
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
                        <h3 class="box-title">Editar usuarios</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route(config('rol')[Auth::user()->id_rol] . '.update-usuario') }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Usuario->id }}">

                                <!-- Nombres Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Nombres') ? 'has-error' : '' }}">
                                    <label for="Nombres">Nombres:</label>
                                    <input class="form-control" name="Nombres" type="text" id="Nombres"
                                        value="{{ $Usuario->Nombres }}">

                                </div>

                                <!-- Apellidos Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Apellidos') ? 'has-error' : '' }}">
                                    <label for="Apellidos">Apellidos:</label>
                                    <input class="form-control" name="Apellidos" type="text" id="Apellidos"
                                        value="{{ $Usuario->Apellidos }}">

                                </div>

                                <!-- NombreUsuario Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('NombreUsuario') ? 'has-error' : '' }}">
                                    <label for="NombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control" name="NombreUsuario" type="text" id="NombreUsuario"
                                        value="{{ $Usuario->NombreUsuario }}">

                                </div>

                                <!-- Email Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email:</label>
                                    <input class="form-control" name="email" type="email" id="email"
                                        value="{{ $Usuario->email }}">
                                </div>

                                <!-- Password Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="password">Nueva contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">
                                </div>

                                <!-- id_rol Field -->
                                <div class="form-group col-sm-6">
                                    <label for="id_rol">Rol:</label>
                                    <select class="form-control id_rol" id="id_rol" name="id_rol">`
                                        @php
                                            $Roles = \App\Models\Rol::all();
                                        @endphp
                                        @foreach ($Roles as $Rol)
                                            <option value="{{ $Rol->id_rol }}"
                                                {{ $Rol->id_rol == $Usuario->id_rol ? 'selected' : '' }}>
                                                {{ $Rol->Rol }}</option>
                                        @endforeach
                                    </select>

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

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="form-submit">Editar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

            </div>
        </div>
    </div>
@endsection
