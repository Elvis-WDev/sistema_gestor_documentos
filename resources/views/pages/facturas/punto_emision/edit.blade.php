@extends('layouts.master')
@section('title')
    DigiDocs || Punto de emisión
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Punto de emisión
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar punto emisión</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('update-punto_emision') }}">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $PuntoEmision->id }}">

                                <!-- Establecimiento Field -->
                                <div
                                    class="form-group col-sm-6 {{ $errors->has('establecimiento_id') ? 'has-error' : '' }}">
                                    <label for="establecimiento_id">Establecimiento:</label>
                                    <select class="form-control" id="establecimiento_id" name="establecimiento_id">

                                        @php
                                            $Establecimiento = \App\Models\Establecimiento::all();
                                        @endphp

                                        @foreach ($Establecimiento as $establecimiento)
                                            <option value="{{ $establecimiento->id }}"
                                                {{ $PuntoEmision->establecimiento_id == $establecimiento->id ? 'selected' : '' }}>
                                                {{ $establecimiento->nombre }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>


                                <!-- nombre Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error' : '' }}">
                                    <label for="nombre">Punto emisión:</label>
                                    <input class="form-control" name="nombre" type="text" id="PuntoEmision"
                                        value="{{ $PuntoEmision->nombre }}">
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

@push('scripts')
    <script>
        $(document).ready(function() {

            $("#PuntoEmision").inputmask({
                mask: "9{1,4}",
                greedy: false,
                placeholder: "",
            });
        });
    </script>
@endpush
