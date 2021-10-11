<x-app-layout>
    @section('title', 'Productos')
        {{-- @endsection --}}

        <x-slot name="header">
            <h5 class="text-center">Productos</h5>
        </x-slot>

        <div class="recuadro mx-auto">
            <div class="">
                <div class="col-md-12">

                    @includeif('partials.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <span class="card-title">Update Producto</span>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('productos.update', $producto->id) }}" role="form"
                                enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                @csrf

                                @include('producto.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
