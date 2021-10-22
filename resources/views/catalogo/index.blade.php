<x-app-layout>
    @section('title', 'Catalogo')
    <x-slot name="header">
        <h5 class="text-center">Catalogo</h5>
    </x-slot>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Catalogo') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('catalogos.create') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Nuevo Catalogo') }}
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
                    <thead class="bg-ibizza text-center">
                        <tr>
                            <th>No</th>

                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Foto Path</th>
                            <th>Pdf Path</th>
                            <th>Fecha Publicacion</th>
                            <th>Fecha Fin Catalogo</th>
                            <th>Estado</th>
                            <th>Premio Id</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($catalogos as $catalogo)
                            <tr>
                                <td>{{ ++$i }}</td>

                                <td>{{ $catalogo->nombre }}</td>
                                <td>{{ $catalogo->descripcion }}</td>
                                <td>{{ $catalogo->foto_path }}</td>
                                <td>{{ $catalogo->pdf_path }}</td>
                                <td>{{ $catalogo->fecha_publicacion }}</td>
                                <td>{{ $catalogo->fecha_fin_catalogo }}</td>
                                <td>{{ $catalogo->estado }}</td>
                                <td>{{ $catalogo->premio_id }}</td>

                                <td>
                                    <form action="{{ route('catalogos.destroy', $catalogo->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary "
                                            href="{{ route('catalogos.show', $catalogo->id) }}"><i
                                                class="fa fa-fw fa-eye"></i> Show</a>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('catalogos.edit', $catalogo->id) }}"><i
                                                class="fa fa-fw fa-edit"></i> Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa fa-fw fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $catalogos->links() !!}

</x-app-layout>
