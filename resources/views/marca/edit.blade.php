<x-app-layout>
    @section('title', 'Editar Marca')
    <x-slot name="header">
        <h5 class="text-center">Editar Marca</h5>
    </x-slot>
    <div class="recuadro mx-auto">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default shadow">
                    <div class="card-header bg-dark p-3">
                        <span class="card-title">Actualizar Marca</span>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('marcas.index') }}"> Regresar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('marcas.update', $marca->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('marca.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>