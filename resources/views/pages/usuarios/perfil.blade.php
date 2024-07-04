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
    {{-- {{ dd(Auth::user()->NombreUsuario) }} --}}
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

                            <div class="row">

                                <input name="id" type="hidden" value="{{ Auth::user()->id }}">

                                <!-- Name Field -->
                                <div class="form-group col-sm-12">
                                    <img src="{{ Auth::user()->url_img == '' ? 'https://www.uniquemedical.com.au/wp-content/uploads/2024/03/Default_pfp.svg.png' : asset('storage/' . Auth::user()->url_img) }}"
                                        class="img-fluid" alt="..." width="200px">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="Nombres">Nombres:</label>
                                    <input class="form-control" name="Nombres" type="text" id="Nombres"
                                        value="{{ Auth::user()->Nombres }}">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="Apellidos">Apellidos:</label>
                                    <input class="form-control" name="Apellidos" type="text" id="Apellidos"
                                        value="{{ Auth::user()->Apellidos }}">
                                </div>

                                <div class="form-group col-sm-6 {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label for="image">Foto de perfil:</label>
                                    <input class="form-control" name="image" type="file" id="image">
                                </div>

                                <!-- Email Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="email">Email:</label>
                                    <input class="form-control" name="email" type="email" id="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <!-- Username Field -->
                                <div class="form-group col-sm-6">
                                    <label for="password">Contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">

                                </div>

                                <!-- Username Field -->
                                <div class="form-group col-sm-6">
                                    <label for="password">Confirmar contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">

                                </div>



                                <div class="form-group col-sm-6">
                                    <label for="NombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control" name="NombreUsuario" type="text" id="NombreUsuario"
                                        value="{{ Auth::user()->NombreUsuario }}" readonly>
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
