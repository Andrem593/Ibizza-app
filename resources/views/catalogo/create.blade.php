@<x-app-layout>
    @section('title', 'Marcas')
        <x-slot name="header">
            EDITAR CATÁLOGO
            <a class="btn btn-secondary btn-sm float-right" href="{{ route('catalogos.index') }}" data-placement="left">
                Regresar</a>
        </x-slot>

        @includeif('partials.errors')

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('catalogos.store') }}" role="form" enctype="multipart/form-data">
                    @csrf

                    @include('catalogo.form')

                </form>
            </div>
        </div>

    </x-app-layout>
