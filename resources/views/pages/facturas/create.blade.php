@extends('layouts.master')
@section('title')
    DigiDocs || Crear Factura
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Facturas
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear factura</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post">
                        <div class="box-body">

                            <div class="row">

                                <!-- FechaEmision Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="FechaEmision">Fecha de emisión:</label>
                                    <input class="form-control" name="FechaEmision" type="text" id="FechaEmision">
                                </div>

                                <!-- Establecimiento Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Establecimiento">Establecimiento:</label>
                                    <input class="form-control" name="Establecimiento" type="text" id="Establecimiento">
                                </div>

                                <!-- PuntoEmision Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="PuntoEmision">Punto de emisión:</label>
                                    <input class="form-control" name="PuntoEmision" type="text" id="PuntoEmision">
                                </div>

                                <!-- Secuencial Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Secuencial">Secuencial:</label>
                                    <input class="form-control" name="Secuencial" type="text" id="Secuencial">
                                </div>

                                <!-- RazonSocial Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="RazonSocial">Razón social:</label>
                                    <input class="form-control" name="RazonSocial" type="text" id="RazonSocial">
                                </div>

                                <!-- Total Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Total">Total:</label>
                                    <input class="form-control" name="Total" type="text" id="Total">
                                </div>
                                <!-- Estado Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Estado">Estado:</label>
                                    <select class="form-control" id="Estado" name="Estado">
                                        <option value="1">Pagada</option>
                                        <option value="2">Anulada</option>
                                        <option value="3">Abonada</option>
                                    </select>
                                </div>

                                <!-- Abono Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Abono">Abono:</label>
                                    <input class="form-control" name="Abono" type="text" id="Abono">
                                </div>



                                <!-- Archivo Field -->
                                <div class="form-group col-sm-12">
                                    <label for="Archivo">Archivos:</label>
                                    {{-- <input type="file" class="custom-file-input form-control" id="Archivo" --}}

                                    <input class="form-control" type="file" name="file" id="dropzone" />


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
