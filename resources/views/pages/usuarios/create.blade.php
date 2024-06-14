@extends('layouts.master')
@section('title')
    DigiDocs || Crear usuario
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Usuarios
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear usuarios</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">

                            <div class="row">
                                <!-- Name Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="NombreUsuario">Nombre de usuario:</label>
                                    <input class="form-control" name="NombreUsuario" type="text" id="NombreUsuario">

                                </div>


                                <!-- Email Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="email">Email:</label>
                                    <input class="form-control" name="email" type="email" id="email">
                                </div>


                                <!-- Username Field -->
                                <div class="form-group col-sm-6 ">
                                    <label for="password">Contraseña:</label>
                                    <input class="form-control" name="password" type="text" id="password">

                                </div>

                                <div class="form-group col-sm-6 ">
                                    <label for="status">Rol:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1">SuperAdmin</option>
                                        <option value="2">Administrador</option>
                                        <option value="3">Usuario</option>
                                    </select>

                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="control-label">Usuarios</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Facturas</label><br>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Pagos</label><br>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Notas de crédito</label><br>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete users"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Solicitud afiliación</label><br>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete tags"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">Retenciones</label><br>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="create documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Crear
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="read documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Visualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="update documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Actualizar
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="">
                                                    <div class="icheckbox_square-blue" style="position: relative;"><input
                                                            name="global_permissions[]" type="checkbox"
                                                            class="iCheck-helper" value="delete documents"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                            class="iCheck-helper"
                                                            style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                    </div>
                                                    &nbsp;Eliminar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
