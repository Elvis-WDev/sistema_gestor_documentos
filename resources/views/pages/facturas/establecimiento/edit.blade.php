@extends('layouts.master')
@section('title')
    DigiDocs || Editar Establecimiento
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Establecimiento
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar establecimiento</h3>
                    </div>
                    <!-- form start -->
                    <form method="post" action="{{ route('update-establecimiento') }}">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Establecimiento->id }}">

                                <!-- nombre Field -->
                                <div class="form-group col-sm-12">
                                    <label for="nombre">Nombre de establecimiento:</label>
                                    <input class="form-control" name="nombre" type="text" id="nombre"
                                        value="{{ $Establecimiento->nombre }}">
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
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->




            </div>
        </div>
    </div>
@endsection
