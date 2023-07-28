<x-app-layout>
    @section('title', 'Pedidos Guardados')
    <x-slot name="header">
        <h5 class="">Pedidos Guardados Vendedores</h5>
    </x-slot>
    <div class="card w-100 mx-auto m-2 shadow">
        @livewire('pedidos-reservados')
    </div>

</x-app-layout>