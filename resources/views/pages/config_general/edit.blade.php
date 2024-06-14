@extends('layouts.master')
@section('title')
    DigiDocs || Editar configuración general
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Configuraciones generales
        </h1>
    </section>
    {{-- {{ dd($Config_generales) }} --}}
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar configuración general</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">

                                <!-- nombre Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="nombre">Nombre:</label>
                                    <input class="form-control" value="{{ $Config_generales->nombre }}" name="nombre"
                                        type="text" id="nombre">
                                </div>

                                <!-- archivos_permitidos Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="archivos_permitidos">Archivos permitidos:</label>
                                    <input class="form-control" name="archivos_permitidos" type="text"
                                        id="archivos_permitidos" value="{{ $Config_generales->archivos_permitidos }}">
                                </div>

                                <!-- cantidad_permitidos Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="cantidad_permitidos">Cantidad de archivo permitidos por subida:</label>
                                    <input class="form-control" name="cantidad_permitidos" type="number"
                                        id="cantidad_permitidos" value="{{ $Config_generales->cantidad_permitidos }}"
                                        min="1" max="5">
                                </div>

                                <!-- tamano_maximo_permitido Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="tamano_maximo_permitido">Tamaño máximo permitido (MB):</label>
                                    <input class="form-control" name="tamano_maximo_permitido" type="number"
                                        id="tamano_maximo_permitido"
                                        value="{{ $Config_generales->tamano_maximo_permitido }}" min="1"
                                        max="5">
                                </div>

                            </div>
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
