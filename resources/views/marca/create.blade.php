<x-app-layout>
    @section('title', 'Crear Marca')
    {{-- @endsection --}}
    <x-slot name="header">
        <h5 class="text-center">Crear Marca</h5>
    </x-slot>
    <div class="recuadro mx-auto">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')
                <div class="card shadow">
                    <div class="card-header bg-dark p-3">
                        <span class="card-title">Nueva Marca</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('marcas.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('marca.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
