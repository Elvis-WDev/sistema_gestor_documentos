@extends('layouts.master')
@section('title')
    DigiDocs || Cuentas por cobrar
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
                        <h3 class="box-title">Anulación de cuenta</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form_anular_factura" role="form" method="POST" action="{{ route('update-anular-factura') }}">
                        @csrf
                        <div class="box-body">

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $Factura->id_factura }}">

                                <!-- Total Field -->
                                <div class="form-group col-sm-6 {{ $errors->has('ValorAnulado') ? 'has-error' : '' }}">
                                    <label for="ValorAnulado">Valor a anular:</label>
                                    <input class="form-control" name="ValorAnulado" type="number" id="ValorAnulado"
                                        min="0" step="any" value="{{ $Abono ? $Abono->saldo_factura : 0 }}">
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
                            <button type="submit" class="btn btn-danger">Anular</button>
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

            $('#form_anular_factura').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Anular factura",
                    text: "No podrás revertirlo!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#42A5F5',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Usa 'this' para referenciar el formulario actual
                    }
                });

            });

        });
    </script>
@endpush
