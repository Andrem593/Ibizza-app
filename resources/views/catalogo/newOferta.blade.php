<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Oferta</h5>
    </x-slot>


    @section('plugins.Select2', true)

    @livewire('oferta')
</x-app-layout>
