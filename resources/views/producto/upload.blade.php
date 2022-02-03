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
                        href="{{ url(asset('storage/formatos/formato_carga_producto.xlsx')) }}" target="_blank"><i
                            class="fas fa-file-excel"></i>
                        Plantilla</a>
                    {{-- <a href="{{ route('productos.index') }}" class="btn btn-ibizza btn-sm float-right"
                            data-placement="left">
                            {{ __('Regresar') }}
                        </a> --}}
                </div>
            </div>
        </div>
        <form action="{{ route('producto.saveExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- <div class="form-group">
                        <label for="marca">Marca de Producto</label>
                        <select class="custom-select form-control-border border-width-2" id="marca" name="marca">
                            <option value="">Seleccione una marca</option>
                            <option>SUA CIA</option>
                            <option>IPANEMA</option>
                            <option>FASOLO</option>
                        </select>
                    </div>
                    @error('marca')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="pedido">Número de pedido</label>
                        <input type="email" class="form-control" name="pedido" placeholder="Ingresa el número de pedido"
                            value="{{ old('pedido') }}">
                    </div>
                    @error('pedido')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    {{-- <div class="form-group">
                        <label for="excel">Carga archivo (.xls)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel" name="excel">
                                <label class="custom-file-label" for="excel">Seleccionar archivo</label>
                            </div>
                        </div>
                    </div> --}}

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
