@extends('layouts.master')
@section('title')
    DigiDocs || Solicitud de afiliados
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
                        <h3 class="box-title">Editar solicitud de afiliados</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">
                                <!-- Prefijo Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Prefijo">Prefijo:</label>
                                    <input class="form-control" name="Prefijo" type="text" id="Prefijo"
                                        value="{{ $SolicitudAfiliados->Prefijo }}">
                                </div>

                                <!-- NombreCliente Field -->
                                <div class="form-group col-sm-6">
                                    <label for="NombreCliente">Nombre del cliente:</label>
                                    <input class="form-control" name="NombreCliente" type="text" id="NombreCliente"
                                        value="{{ $SolicitudAfiliados->NombreCliente }}">
                                </div>

                                <!-- Archivo Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Archivo">Archivos:</label>
                                    <input type="file" class="custom-file-input form-control" id="Archivo"
                                        name="Archivo">
                                </div>

                                <!-- Fecha registro Field -->
                                <div class="form-group col-sm-6">
                                    <label>Fecha de registro:</label>

                                    <input type="text" class="form-control pull-right" id="created_at">

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
