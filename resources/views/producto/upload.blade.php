<x-app-layout>
    @section('title', 'Carga Producto')
        <x-slot name="header">
            <h5 class="text-center">CARGA DE PRODUCTOS</h5>
        </x-slot>

        <div class="recuadro mx-auto shadow">
            <div class="card-header bg-dark p-3">
                <h3 class="card-title">Productos</h3>
            </div>

            <form action="{{ route('producto.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
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
                    <div class="form-group">
                        <label for="excel">Carga archivo (.xls)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel" name="excel">
                                <label class="custom-file-label" for="excel">Seleccionar archivo</label>
                            </div>
                        </div>
                    </div>
                    @error('excel')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark">Cargar productos</button>
                </div>
            </form>

        </div>
    </x-app-layout>


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
