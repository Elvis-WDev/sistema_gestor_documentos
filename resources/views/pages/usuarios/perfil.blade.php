@extends('layouts.master')
@section('title')
    DigiDocs || Perfil de usuario
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Perfil de usuario
        </h1>
    </section>
    {{-- {{ dd($user) }} --}}
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">
                                <!-- Name Field -->
                                <div class="form-group col-sm-12 ">
                                    <img src="https://pic.onlinewebfonts.com/thumbnails/icons_312847.svg" class="img-fluid"
                                        alt="..." width="200px">
                                </div>
                                <div class="form-group col-sm-12 ">
                                    <label for="NombreUsuario">Foto de perfil:</label>
                                    <input class="form-control" name="NombreUsuario" type="file" id="NombreUsuario">

                                </div>
                                <div class="form-group col-sm-12 ">
                                    <label for="NombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control" name="NombreUsuario" type="text" id="NombreUsuario">

                                </div>


                                <!-- Email Field -->
                                <div class="form-group col-sm-12 ">
                                    <label for="email">Email:</label>
                                    <input class="form-control" name="email" type="email" id="email">
                                </div>


                                <!-- Username Field -->
                                <div class="form-group col-sm-12 ">
                                    <label for="password">Contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">

                                </div>

                                <!-- Username Field -->
                                <div class="form-group col-sm-12 ">
                                    <label for="password">Confirmar contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">

                                </div>

                                <div class="form-group col-sm-12 ">
                                    <label for="status">Rol:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">SuperAdmin</option>
                                        <option value="2">Administrador</option>
                                        <option value="3">Usuario</option>
                                    </select>

                                </div>

                            </div>
                        </div>
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
