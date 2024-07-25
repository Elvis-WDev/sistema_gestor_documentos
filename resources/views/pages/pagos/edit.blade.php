@extends('layouts.master')
@section('title')
    DigiDocs || Pagos
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
                        <h3 class="box-title">Editar Pago</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('update-pago') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">

                            <input type="hidden" name="id_pago" value="{{ $Pago->id_pago }}">
                            <input type="hidden" name="old_archivos" value="{{ $Pago->Archivos }}">

                            <div class="form-group col-sm-6" data-select2-id="13">
                                <label>Factura #:</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    data-select2-id="1" tabindex="-1" aria-hidden="true" name="id_factura">
                                    @php
                                        $facturas = \App\Models\Factura::with([
                                            'establecimiento',
                                            'puntoEmision',
                                        ])->get();
                                    @endphp

                                    @foreach ($facturas as $factura)
                                        <option data-select2-id="{{ $factura->id_factura }}"
                                            value="{{ $factura->id_factura }}"
                                            {{ $Pago->id_factura == $factura->id_factura ? 'selected' : '' }}>
                                            {{ $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <!--  FechaPago -->
                            <div class="form-group col-sm-6">
                                <label for="FechaPago">Fecha de pago:</label>
                                <input class="form-control" name="FechaPago" type="text" id="FechaPagoUpdate"
                                    value="{{ $Pago->FechaPago }}">
                            </div>

                            <!-- Monto Field -->
                            <div class="form-group col-sm-6">
                                <label for="Cantidad">Cantidad:</label>
                                <input class="form-control" name="Total" type="number" id="Cantidad" min="0"
                                    step="any" value="{{ $Pago->Total }}">
                            </div>

                            <!-- Fecha Field -->
                            <div class="form-group col-sm-6">
                                <label for="updated_at">Última modificación:</label>
                                <input class="form-control" name="Fecha" type="text" id="updated_at"
                                    value="{{ $Pago->updated_at }}" disabled>
                            </div>

                            <!-- Archivos Field -->
                            <div class="form-group col-sm-6">
                                <label for="Total">Archivos subidos:</label></br>
                                @php
                                    $Files = json_decode($Pago->Archivos);
                                @endphp

                                @foreach ($Files as $file)
                                    <div class="btn-group">
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                            data-tippy-content="{{ substr($file, 17) }}" class="btn btn-default btn-md">
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
