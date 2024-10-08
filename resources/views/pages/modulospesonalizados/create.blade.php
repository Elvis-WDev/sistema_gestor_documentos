@extends('layouts.master')
@section('title')
    Crear carpeta
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Carpetas
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear carpeta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!--  form start -->
                    <form method="POST" role="form" action="{{ route('store-custom_module') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">
                                <input type="hidden" name="id_usuario" value="{{ Auth::user()->id }}">
                                <!-- Establecimiento Field -->
                                <div class="form-group col-sm-12 {{ $errors->has('NombreModulo') ? 'has-error' : '' }}">
                                    <label for="NombreModulo">Nombre de carpeta:</label>
                                    <input class="form-control" name="NombreModulo" type="text" id="NombreModulo">
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
