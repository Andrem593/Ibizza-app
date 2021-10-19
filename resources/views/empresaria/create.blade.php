<x-app-layout>
    @section('title', 'Empresarias')
    <x-slot name="header">
        <h5 class="text-center">Marcas</h5>
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Empresaria</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('empresarias.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('empresaria.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>