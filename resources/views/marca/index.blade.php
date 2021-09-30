<x-app-layout>
    @section('title', 'Marcas')
    {{-- @endsection --}}

    <x-slot name="header">
        <h5 class="text-center">MARCAS</h5>
    </x-slot>

    <div class="recuadro mx-auto">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow">
                    <div class="card-header bg-dark p-3">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Marca') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('marcas.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Nueva Marca') }}
                                </a>
                            </div>
                        </div>
                    </div>
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

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($marcas as $marca)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $marca->nombre }}</td>
                                            <td>{{ $marca->imagen }}</td>

                                            <td>
                                                <form action="{{ route('marcas.destroy', $marca->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('marcas.show', $marca->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> Ver</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('marcas.edit', $marca->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> Editar</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i> Eliminar</button>
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
            </div>
        </div>
    </div>
</x-app-layout>
