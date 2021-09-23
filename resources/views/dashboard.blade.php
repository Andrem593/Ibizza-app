<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-card>
        <x-slot name="title">
            prueba
        </x-slot>c
        <x-slot name="body">
            componente
        </x-slot>
        {{-- hola --}}
    </x-card>
</x-app-layout>