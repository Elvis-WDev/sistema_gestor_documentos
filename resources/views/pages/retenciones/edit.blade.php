@extends('layouts.master')
@section('title')
    DigiDocs || Retenciones
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Retenciones
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar retención</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">

                                <!-- FechaEmision Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="FechaEmision">Fecha de emisión:</label>
                                    <input class="form-control" name="FechaEmision" type="text" id="FechaEmision"
                                        value="{{ $Retencion->FechaEmision }}">
                                </div>

                                <!-- Establecimiento Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Establecimiento">Establecimiento:</label>
                                    <input class="form-control" name="Establecimiento" type="text" id="Establecimiento"
                                        value="{{ $Retencion->Establecimiento }}">
                                </div>

                                <!-- PuntoEmision Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="PuntoEmision">Punto de emisión:</label>
                                    <input class="form-control" name="PuntoEmision" type="text" id="PuntoEmision"
                                        value="{{ $Retencion->PuntoEmision }}">
                                </div>

                                <!-- Secuencial Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Secuencial">Secuencial:</label>
                                    <input class="form-control" name="Secuencial" type="text" id="Secuencial"
                                        value="{{ $Retencion->Secuencial }}">
                                </div>

                                <!-- RazonSocial Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="RazonSocial">Razón social:</label>
                                    <input class="form-control" name="RazonSocial" type="text" id="RazonSocial"
                                        value="{{ $Retencion->RazonSocial }}">
                                </div>

                                <!-- Total Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Total">Total:</label>
                                    <input class="form-control" name="Total" type="text" id="Total"
                                        value="{{ $Retencion->Total }}">
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
