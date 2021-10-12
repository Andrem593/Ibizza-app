<x-app-layout>
    @section('title', 'Marcas')
        <x-slot name="header">
            MARCAS
            <a href="{{ route('marcas.create') }}" class="btn btn-secondary btn-sm float-right" data-placement="left">
                {{ __('Nueva Marca') }}
            </a>
        </x-slot>
        <div class="card">            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                            <tr>
                                <th>No</th>

                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Estado</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marcas as $marca)
                                <tr>
                                    <td class="my-auto">{{ ++$i }}</td>

                                    <td class="my-auto">{{ $marca->nombre }}</td>
                                    <td class="my-auto"><img src="/storage/images/marca/{{ $marca->imagen }}"
                                            width="100px" class="img-circle elevation-2 img-fluid"
                                            style="max-height: 80px; width: auto">
                                    </td>
                                    <td class="my-auto">{{ $marca->estado }}</td>

                                    <td class="my-auto">
                                        <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST">

                                            <div class="btn-group">
                                                <a class="btn btn-secondary"
                                                    href="{{ route('marcas.show', $marca->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-primary" href="{{ route('marcas.edit', $marca->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    href="{{ route('marcas.show', $marca->id) }}">
                                                    <i class="fa fa-fw fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {!! $marcas->links() !!}
    </x-app-layout>
