<x-app-layout>
    @section('title', 'Carga Ventas')
    <x-slot name="header">
        CARGA DE VENTAS
    </x-slot>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Ventas') }}
                </span>
                <div class="float-right">
                    <a class="btn btn-success btn-sm mr-2"
                        href="{{ url(asset('storage/formatos/formato_carga_venta.xlsx')) }}" target="_blank"><i
                            class="fas fa-file-excel"></i>
                        Plantilla</a>
                </div>
            </div>
        </div>
        <form action="{{ route('venta.saveExcel') }}" method="POST" enctype="multipart/form-data" role="form">
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
                <button type="submit" class="btn btn-ibizza">Cargar ventas</button>
            </div>
        </form>

    </div>
    
    @push('js')
        <script>
            $(document).ready(function() {
                $('form').submit(function(event) {
                    if ($(this).hasClass('submitted')) {
                        $(this).find(':submit').html('Cargar ventas');
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
