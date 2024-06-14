@extends('layouts.master')
@section('title')
    DigiDocs || Crear Pago
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
                        <h3 class="box-title">Crear pagos</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">

                                <div class="form-group col-sm-6" data-select2-id="13">
                                    <label>Factura</label>
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                        data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        @php
                                            $facturas = \App\Models\Factura::all();
                                        @endphp

                                        @foreach ($facturas as $factura)
                                            <option data-select2-id="3">{{ $factura->Archivo }}</option>
                                        @endforeach


                                        {{-- <option data-select2-id="21">Alaska</option>
                                        <option data-select2-id="22">California</option>
                                        <option data-select2-id="23">Delaware</option>
                                        <option data-select2-id="24">Tennessee</option>
                                        <option data-select2-id="25">Texas</option>
                                        <option data-select2-id="26">Washington</option> --}}
                                    </select>
                                </div>

                                <!-- Monto Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Monto">Monto:</label>
                                    <input class="form-control" name="Monto" type="text" id="Monto">
                                </div>

                                <!-- Fecha Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="Fecha">Fecha de registro:</label>
                                    <input class="form-control" name="Fecha" type="text" id="Fecha">
                                </div>

                                <!-- Archivo Field -->
                                <div class="form-group col-sm-6 ">
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
