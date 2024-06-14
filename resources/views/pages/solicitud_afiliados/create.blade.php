@extends('layouts.master')
@section('title')
    DigiDocs || Crear solicitud de afiliado
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
                        <h3 class="box-title">Crear solicitud de afiliado</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">

                                <!-- Monto Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Prefijo">Prefijo:</label>
                                    <input class="form-control" name="Prefijo" type="text" id="Prefijo">
                                </div>

                                <!-- Fecha Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="NombreCliente">Nombre de cliente:</label>
                                    <input class="form-control" name="NombreCliente" type="text" id="NombreCliente">
                                </div>

                                <!-- Archivo Field -->
                                <div class="form-group col-sm-12 ">
                                    <label for="Archivo">Archivos:</label>
                                    <input type="file" class="custom-file-input form-control" id="Archivo"
                                        name="Archivo">
                                </div>

                            </div>
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
