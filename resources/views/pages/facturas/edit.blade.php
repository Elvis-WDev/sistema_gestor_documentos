@extends('layouts.master')
@section('title')
    DigiDocs || Factura
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Facturas
        </h1>
    </section>
    <div class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar factura</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('update-factura') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Factura->id_factura }}">

                                <input type="hidden" name="old_archivos" value="{{ $Factura->Archivos }}">

                                <div
                                    class="form-group col-sm-3 {{ $errors->has('establecimiento_id') ? 'has-error' : '' }}">
                                    <label for="establecimiento_id">Establecimiento:</label>
                                    <select class="form-control establecimiento_id" id="establecimiento_id"
                                        name="establecimiento_id">
                                        @php
                                            $Establecimientos = \App\Models\Establecimiento::all();
                                        @endphp
                                        <option value="">
                                            Seleccione:
                                        </option>
                                        @foreach ($Establecimientos as $establecimiento)
                                            <option value="{{ $establecimiento->id }}"
                                                {{ $establecimiento->id == $Factura->establecimiento_id ? 'selected' : '' }}>
                                                {{ $establecimiento->nombre }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <!-- Punto emision Field -->
                                <div class="form-group col-sm-3 {{ $errors->has('punto_emision_id') ? 'has-error' : '' }}">
                                    @php
                                        $PuntoEmision = \App\Models\PuntoEmision::where(
                                            'establecimiento_id',
                                            $Factura->establecimiento_id,
                                        )->get();
                                    @endphp
                                    <label for="punto_emision_id">Punto emisión:</label>
                                    <select class="form-control punto_emision_id" id="punto_emision_id"
                                        name="punto_emision_id">
                                        @foreach ($PuntoEmision as $SelectedPuntoEmision)
                                            <option value="{{ $SelectedPuntoEmision->id }}"
                                                {{ $SelectedPuntoEmision->id == $Factura->punto_emision_id ? 'selected' : '' }}>
                                                {{ $SelectedPuntoEmision->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Secuencial Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Secuencial') ? 'has-error' : '' }}">
                                    <label for="Secuencial">Secuencial:</label>
                                    <input class="form-control" name="Secuencial" type="text" id="Secuencial"
                                        value="{{ $Factura->Secuencial }}">
                                </div>

                                <!-- RazonSocial Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('RazonSocial') ? 'has-error' : '' }}">
                                    <label for="RazonSocial">Razón social:</label>
                                    <input class="form-control" name="RazonSocial" type="text" id="RazonSocial"
                                        value="{{ $Factura->RazonSocial }}">
                                </div>

                                <!-- FechaEmision Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('FechaEmision') ? 'has-error' : '' }}">
                                    <label for="FechaEmisionEdit">Fecha de emisión:</label>
                                    <input class="form-control" name="FechaEmision" type="text" id="FechaEmisionEdit"
                                        value="{{ $Factura->FechaEmision }}">
                                </div>

                                <!-- Total Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('Total') ? 'has-error' : '' }}">
                                    <label for="Total">Total:</label>
                                    <input class="form-control" name="Total" type="number" id="Total" min="0"
                                        step="any" value="{{ $Factura->Total }}" disabled>
                                </div>

                                <!-- ultima modificacion Field -->
                                <div class="form-group col-sm-6">
                                    <label for="updated_at">última modificación:</label>
                                    <input class="form-control updated_at" name="updated_at" type="text" id="updated_at"
                                        value="{{ $Factura->updated_at }}" disabled>
                                </div>

                                <!-- Archivos Field -->
                                <div class="form-group col-sm-6">
                                    <label for="Total">Archivos subidos:</label></br>
                                    @php
                                        $Files = json_decode($Factura->Archivos);
                                    @endphp

                                    @foreach ($Files as $file)
                                        <div class="btn-group">
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                                data-tippy-content="{{ substr($file, 17) }}"
                                                class="btn btn-default btn-md">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="form-group col-sm-12">

                                    <label for="Total">Nuevos Archivos:</label></br>
                                    <div class="fileList" id="fileList"></div>

                                </div>

                                <div class="form-group col-sm-12">

                                    <div class="dropzone" id="dropzone">
                                        <i class="far fa-copy icon"></i></br></br>
                                        Arrastra y suelta archivos aquí o haz clic para subir nuevos
                                        <input type="file" id="fileInput" class="Archivos fileInput" name="Archivos[]"
                                            multiple>
                                    </div>

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
        // Cargar datos de punto emision de acuerdo a establecimiento seleccionado
        $('body').on('change', '.establecimiento_id', function(e) {
            let id = $(this).val();
            if (id != 0) {

                $.ajax({
                    method: 'GET',
                    url: "{{ route('get-punto_emision') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {

                        $('.punto_emision_id').empty();
                        $.each(data, function(i, item) {
                            $('.punto_emision_id').append(
                                `<option value="${item.id}">${item.nombre}</option>`
                            )
                        })

                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            } else {
                $('.punto_emision_id').empty();
                $('.punto_emision_id').append(`<option value="0">Seleccione:</option>`);
            }


        })


        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.querySelector('.dropzone');
            const fileInput = document.querySelector('.fileInput');
            const fileList = document.querySelector('.fileList');

            dropzone.addEventListener('click', () => {
                fileInput.click();
            });

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('hover');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('hover');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('hover');
                handleFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', (e) => {
                e.preventDefault();
                handleFiles(e.target.files);
            });

            function handleFiles(files) {
                console.log(files);

                // Crear un objeto DataTransfer para manejar los archivos
                const dataTransfer = new DataTransfer();

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    dataTransfer.items.add(file);
                }

                // Opcional: Mostrar los archivos en fileList
                fileList.innerHTML = ''; // Limpiar la lista antes de mostrar los archivos
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item col-sm-3';
                    fileItem.textContent = `${file.name}`;
                    fileList.appendChild(fileItem);
                }

                // Asignar los archivos al input Archivos[]
                const archivosInput = document.querySelector('.Archivos');
                archivosInput.files = dataTransfer.files;
            }
        });
    </script>
@endpush
