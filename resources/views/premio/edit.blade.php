<x-app-layout>
    @section('title', 'Premios')
    <x-slot name="header">
        PREMIO
        <a class="btn btn-secondary btn-sm float-right" href="{{ route('premios.index') }}" data-placement="left">
            Regresar</a>
    </x-slot>

    @includeif('partials.errors')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Actualizar Premio</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('premios.update', $premio->id) }}" role="form"
                enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                @csrf

                @include('premio.formUpdate')

            </form>
        </div>
    </div>

</x-app-layout>
