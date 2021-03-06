<x-app-layout>
    @section('title', 'Marcas')
        <x-slot name="header">
            EDITAR MARCA
            <a class="btn btn-secondary btn-sm float-right" href="{{ route('marcas.index') }}" data-placement="left"> Regresar</a>
        </x-slot>
    

        @includeif('partials.errors')

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('marcas.update', $marca->id) }}"  role="form" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    @csrf

                    @include('marca.form')

                </form>
            </div>
        </div>
</x-app-layout>