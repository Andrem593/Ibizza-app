<x-app-layout>
    @section('title', 'Tomar Pedidos')
    <x-slot name="header">
        <h5 class="">Toma de Pedidos</h5>
    </x-slot>
    <div class="card w-100 mx-auto m-4 p-4 shadow">     
        @livewire('tomar-pedido', ['id_empresaria' => $empresaria ? $empresaria->id : null, 'envio' => $envio])
    </div>

</x-app-layout>