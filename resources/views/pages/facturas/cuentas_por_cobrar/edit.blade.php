@extends('layouts.master')
@section('title')
    Cuentas por cobrar
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Cuentas por cobrar
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar cuenta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('update-cuentas') }}">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Factura->id_factura }}">

                                <!-- Total Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('RetencionIva') ? 'has-error' : '' }}">
                                    <label for="RetencionIva">Retención iva:</label>
                                    <input class="form-control" name="RetencionIva" type="number" id="RetencionIva"
                                        min="0" step="any" value="{{ $Factura->RetencionIva }}"
                                        {{ $Factura->Estado != 'Registrada' ? 'disabled' : '' }}>
                                </div>
                                <!-- Total Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('RetencionFuente') ? 'has-error' : '' }}">
                                    <label for="RetencionFuente">Retención fuente:</label>
                                    <input class="form-control" name="RetencionFuente" type="number" id="RetencionFuente"
                                        min="0" step="any" value="{{ $Factura->RetencionFuente }}"
                                        {{ $Factura->Estado != 'Registrada' ? 'disabled' : '' }}>
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

                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"
                                {{ $Factura->Estado != 'Registrada' ? 'disabled' : '' }}>Guardar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->




            </div>
        </div>
    </div>
@endsection
