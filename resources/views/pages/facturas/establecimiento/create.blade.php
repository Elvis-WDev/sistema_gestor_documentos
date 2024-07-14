@extends('layouts.master')
@section('title')
    DigiDocs || Establecimientos
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Establecimientos
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear establecimiento</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('store-establecimiento') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <!-- Nombre Field -->
                                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                                    <label for="nombre">Nombre de establecimiento:</label>
                                    <input class="form-control" name="nombre" type="text" id="nombre"
                                        value="{{ old('nombre') }}">
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
