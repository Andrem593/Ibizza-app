<x-app-layout>
    @section('title', 'Cambios Reservados')
    <x-slot name="header">
        <h5 class="">Cambios Reservados</h5>
    </x-slot>
    <div class="card w-100 mx-auto m-2 shadow">
        @livewire('reservar-cambio-pedido')
    </div>

</x-app-layout>
