<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Oferta</h5>
    </x-slot>

    @livewire('oferta', ['editOferta' => $oferta])
    
</x-app-layout>
