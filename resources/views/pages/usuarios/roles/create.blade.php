@extends('layouts.master')
@section('title')
    DigiDocs || Crear Roles
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Roles
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('store-rol') }}" method="post">
                        @csrf

                        <div class="box-body">

                            <div class="row">

                                <!-- Nombres Field -->
                                <div class="form-group col-sm-12 {{ $errors->has('Nombres') ? 'has-error' : '' }}">
                                    <label for="name">Nombre de rol:</label>
                                    <input class="form-control" name="name" type="text" id="name"
                                        value="{{ old('name') }}">
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


                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label">Usuario</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;">
                                                        <input name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear usuario"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear usuarios
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver usuario"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver usuarios
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar usuario"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar usuarios
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Facturas</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear facturas"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear facturas
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver facturas"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver facturas
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar facturas"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar facturas
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Pagos</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver pagos"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver pagos
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear pagos"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear pagos
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar pagos"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar pagos
                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Notas credito</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver NotasCredito"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver notas cred
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear NotasCredito"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear notas cred
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar NotasCreditos"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar notas cred
                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Solicitud afiliado</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver SolicitudAfiliado"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver solicitud afil.
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear SolicitudAfiliado"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear solicitud afil.
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar SolicitudAfiliado"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar solicitud afil.
                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Retenciones</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="ver retenciones"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Ver retenciones
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="crear retenciones"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear retenciones
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="permissions[]" type="checkbox" class="iCheck-helper"
                                                            value="modificar retenciones"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Modificar retenciones
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="form-submit">Crear</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->




            </div>
        </div>
    </div>
@endsection
