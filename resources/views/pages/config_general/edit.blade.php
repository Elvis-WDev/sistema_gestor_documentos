@extends('layouts.master')
@section('title')
    Editar configuración general
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Configuraciones generales
        </h1>
    </section>
    {{-- {{ dd($Config_generales) }} --}}
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar configuración general</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('update-configuracion') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Config_generales->id }}">

                                <!-- nombre Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                                    <label for="nombre">Nombre:</label>
                                    <input class="form-control" value="{{ $Config_generales->nombre }}" name="nombre"
                                        type="text" id="nombre">
                                </div>

                                <!-- cantidad_permitidos Field -->
                                <div
                                    class="form-group col-sm-6 {{ $errors->has('cantidad_permitidos') ? 'has-error' : '' }}">
                                    <label for="cantidad_permitidos">Cantidad de archivo permitidos por subida:</label>
                                    <input class="form-control" name="cantidad_permitidos" type="number"
                                        id="cantidad_permitidos" value="{{ $Config_generales->cantidad_permitidos }}"
                                        min="1" max="5">
                                </div>

                                <!-- tamano_maximo_permitido Field -->
                                <div
                                    class="form-group col-sm-6 {{ $errors->has('tamano_maximo_permitido') ? 'has-error' : '' }}">
                                    <label for="tamano_maximo_permitido">Tamaño máximo permitido (MB):</label>
                                    <input class="form-control" name="tamano_maximo_permitido" type="number"
                                        id="tamano_maximo_permitido"
                                        value="{{ $Config_generales->tamano_maximo_permitido }}" min="1">
                                </div>

                                @php
                                    $allowedFilesArray = explode(',', $Config_generales->archivos_permitidos);
                                @endphp
                                <div
                                    class="form-group col-sm-6 {{ $errors->has('archivos_permitidos') ? 'has-error' : '' }}">
                                    <label>Archivos permitidos</label>
                                    <select class="form-control select2" style="width: 100%;" name="archivos_permitidos[]"
                                        multiple>
                                        @foreach (config('config_general')['mimes'] as $categoria => $extensiones)
                                            <optgroup label="{{ $categoria }}">
                                                @foreach ($extensiones as $extension)
                                                    <option value="{{ $extension }}"
                                                        {{ in_array($extension, $allowedFilesArray) ? 'selected' : '' }}>
                                                        {{ $extension }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
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
