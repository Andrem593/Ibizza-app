<x-app-layout>
    @section('title', 'Cambios')
    <x-slot name="header">
        <h5 class="">Cambios en Pedidos</h5>
    </x-slot>

    <div class="card w-100 mx-auto m-4 p-4 shadow">
        @livewire('formato-cambio')
    </div>

</x-app-layout>