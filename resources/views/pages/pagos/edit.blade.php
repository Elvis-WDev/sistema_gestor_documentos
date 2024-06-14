@extends('layouts.master')
@section('title')
    DigiDocs || Pagos
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Pagos
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar pago</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">

                                <!-- Estado Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Estado">Factura:</label>
                                    <select class="form-control" id="Estado" name="Estado">
                                        @foreach ($TodasLasFacturas as $Factura)
                                            <option value="{{ $Factura->id_factura }}"
                                                {{ $Factura->id_factura == $Pago->id_factura ? 'selected' : '' }}>
                                                {{ $Factura->Secuencial . ' (' . $Factura->Estado . ')' }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <!-- Total Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Total">Total pago:</label>
                                    <input class="form-control" name="Total" type="text" id="Total"
                                        value="{{ $Pago->Total }}">
                                </div>

                                <!-- Establecimiento Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Fecha">Fecha:</label>
                                    <input class="form-control" name="Fecha" type="text" id="Fecha"
                                        value="{{ $Pago->Fecha }}">
                                </div>

                                <!-- Fecha registro Field -->
                                <div class="form-group col-sm-6">
                                    <label>Fecha de registro:</label>

                                    <input type="text" class="form-control pull-right" id="created_at">

                                </div>

                                <!-- Archivo Field -->
                                <div class="form-group col-sm-12">
                                    <label for="Archivo">Archivos:</label>
                                    <input type="file" class="custom-file-input form-control" id="Archivo"
                                        name="Archivo">
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
