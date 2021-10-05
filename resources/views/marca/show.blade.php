<x-app-layout>
    @section('title', 'Ver Marca')
    {{-- @endsection --}}
    <x-slot name="header">
        <h5 class="text-center">Ver Marca</h5>
    </x-slot>
    <div class="recuadro mx-auto">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-dark p-3">
                        <div class="float-left">
                            <span class="card-title">Ver Marca</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('marcas.index') }}"> Regresar</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $marca->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Imagen:</strong>
                            <img src="/storage/images/marca/{{ $marca->imagen }}" width="500px">
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
