<x-app-layout>
    @section('title', 'Marcas')
        <x-slot name="header">
            CREAR MARCA
            <a class="btn btn-secondary btn-sm float-right" href="{{ route('marcas.index') }}" data-placement="left"> Regresar</a>
        </x-slot>
    

        @includeif('partials.errors')
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('marcas.store') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf

                    @include('marca.form')

                </form>
            </div>
        </div>

</x-app-layout>
