@extends('layouts.master')
@section('title')
    DigiDocs || Edit Roles
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
                    <form role="form" action="{{ route('update-rol') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $role->id }}">

                                <!-- Nombres Field -->
                                <div class="form-group col-sm-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name">Nombre de rol:</label>
                                    <input class="form-control" name="name" type="text" id="name"
                                        value="{{ $role->name }}">
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
                                        @foreach ($permissions as $permission)
                                            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="form-group">
                                                    <label>
                                                        <div class="icheckbox_square-blue" style="position: relative;">
                                                            <input name="permissions[]" type="checkbox"
                                                                class="iCheck-helper" value="{{ $permission->name }}"
                                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                                style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins
                                                                class="iCheck-helper"
                                                                style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                        </div>
                                                        &nbsp;{{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="form-submit">Editar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->




            </div>
        </div>
    </div>
@endsection
