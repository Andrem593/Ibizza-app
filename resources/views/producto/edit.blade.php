<x-app-layout>
    @section('title', 'Productos')
        {{-- @endsection --}}

        <x-slot name="header">
            <h5 class="text-center">Productos</h5>
        </x-slot>

        <div class="mx-auto">
            <div class="">
                <div class="col-md-12">

                    @includeif('partials.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <span class="card-title">Editar Producto</span>
                            <div class="float-right">
                                <a href="{{ route('productos.index') }}" class="btn btn-ibizza btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Regresar') }}
                                </a>
                            </div>
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
