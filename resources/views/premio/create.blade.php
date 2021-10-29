<x-app-layout>
    @section('title', 'Premios')
    <x-slot name="header">
        CREAR PREMIO
        <a class="btn btn-secondary btn-sm float-right" href="{{ route('premios.index') }}" data-placement="left">
            Regresar</a>
    </x-slot>

    @includeif('partials.errors')

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">Premio</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('premios.store') }}" role="form" enctype="multipart/form-data">
                @csrf

                @include('premio.form')

            </form>
        </div>
    </div>
</x-app-layout>
