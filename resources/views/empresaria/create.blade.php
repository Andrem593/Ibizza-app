<x-app-layout>
    @section('title', 'Empresarias')
    <x-slot name="header">
        <h5 class="text-center">Empresarias</h5>
    </x-slot>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Crear Empresaria</span>
                        <div class="float-right">
                            <a href="{{ route('empresarias.index') }}" class="btn btn-ibizza btn-sm float-right"  data-placement="left">
                                <i class="fas fa-chevron-left me-1"></i>{{ __('Regresar') }}
                            </a>
                        </div>
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