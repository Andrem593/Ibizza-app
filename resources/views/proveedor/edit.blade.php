<x-app-layout>
    @section('title', 'Proveedor')
    {{-- @endsection --}}

    <x-slot name="header">
        <h5 class="text-center">Proveedor</h5>
    </x-slot>

    <div class="mx-auto">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Editar Proveedor</span>
                        <div class="float-right">
                            <a href="{{ route('proveedores.index') }}" class="btn btn-ibizza btn-sm float-right"
                                data-placement="left">
                                {{ __('Regresar') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('proveedor.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
