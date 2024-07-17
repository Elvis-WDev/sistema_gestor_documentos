@extends('layouts.master')
@section('title')
    DigiDocs || Crear módulo
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Módulos
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear módulo</h3>
                    </div>
                    <!-- /.box-header -->
                    <!--  form start -->
                    <form method="POST" role="form" action="{{ route('store-custom_module') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <!-- Establecimiento Field -->
                                <div class="form-group col-sm-12 ">
                                    <label for="NombreModulo">Nombre del Módulo:</label>
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
