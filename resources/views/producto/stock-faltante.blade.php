<x-app-layout>
    @section('title', 'Stock')
        {{-- @endsection --}}

        <x-slot name="header">
            <h5 class="text-center">Historial de Stock</h5>
        </x-slot>


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Historial de Stock') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table id="datatable" class="display table table-striped table-sm table-hover fw-bold">
                                <thead class="bg-ibizza text-center">
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CATÁLOGO</th>
                                        <th>ESTILO</th>
                                        <th>COLOR</th>
                                        <th>TALLA</th>
                                        <th>CANTIDAD</th>
                                        <th>FECHA REQUERIMIENTO</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @push('css')
                    <link rel="stylesheet" href="/css/botonesDataTable.css">
                @endpush
                
                @Push('scripts')
                    <script src="/js/crearDataTable1.js"></script>
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
                        $(document).ready(function() {
                            crearDataTable();
                        });
                        function crearDataTable() {
                            var data = {
                                funcion: 'listar_STOCK',
                            }
                            let ruta = '/producto/datatableStock';
                            stockFaltante(data, ruta);
                        }
                    </script>
                @endpush
            </div>
        </div>
    </x-app-layout>
