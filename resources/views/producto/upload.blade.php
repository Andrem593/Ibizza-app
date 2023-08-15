<x-app-layout>
    @section('title', 'Carga Producto')
    <x-slot name="header">
        CARGA DE PRODUCTOS
    </x-slot>



    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Producto') }}
                </span>
                <div class="float-right">
                    <a class="btn btn-success btn-sm mr-2"
                        href="{{ url(asset('storage/formatos/formato_carga_producto3.xlsx')) }}" target="_blank"><i
                            class="fas fa-file-excel"></i>
                        Plantilla</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('error'))
            <div class="alert alert-warning">
                <p>{{ $message }}</p>
            </div>
        @endif


        <form action="{{ route('producto.saveExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                @section('plugins.BsCustomFileInput', true)

                <x-adminlte-input-file name="excel" class="" igroup-size="sm"
                    label="Carga archivo (.xls, .xlsx)" legend="Seleccionar"
                    placeholder="Escoger un archivo .xls o .xlsx"
                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                    <x-slot name="prependSlot">
                        <div class="input-group-text btn-ibizza">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>

                </x-adminlte-input-file>

                {{-- @error('excel')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror --}}

            </div>
            <!-- /.card-body -->

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-ibizza">Cargar productos</button>
            </div>
        </form>

    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('form').submit(function(event) {
                    if ($(this).hasClass('submitted')) {
                        $(this).find(':submit').html('Cargar productos');
                        $(this).find(':submit').attr("disabled", false);
                        event.preventDefault();
                    } else {
                        $(this).find(':submit').attr("disabled", true);
                        $(this).find(':submit').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...'
                        );
                        $(this).addClass('submitted');
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>


@Section('js')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    @if (session('message'))
        <script>
            Toast.fire({
                icon: 'success',
                title: 'Se cargaron los productos correctamente.'
            })
        </script>
    @endif
@stop
