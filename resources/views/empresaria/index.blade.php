<x-app-layout>
    @section('title', 'Empresarias')
    <x-slot name="header">
        <h5 class="text-center">Marcas</h5>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Empresaria') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('empresarias.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                                        
										<th>Cedula</th>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Fecha Nacimiento</th>
										<th>Direccion</th>
										<th>Tipo Cliente</th>
										<th>Estado</th>
										<th>Telefono</th>
										<th>Id Ciudad</th>
										<th>Vendedor</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresarias as $empresaria)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $empresaria->cedula }}</td>
											<td>{{ $empresaria->nombres }}</td>
											<td>{{ $empresaria->apellidos }}</td>
											<td>{{ $empresaria->fecha_nacimiento }}</td>
											<td>{{ $empresaria->direccion }}</td>
											<td>{{ $empresaria->tipo_cliente }}</td>
											<td>{{ $empresaria->estado }}</td>
											<td>{{ $empresaria->telefono }}</td>
											<td>{{ $empresaria->id_ciudad }}</td>
											<td>{{ $empresaria->vendedor }}</td>

                                            <td>
                                                <form action="{{ route('empresarias.destroy',$empresaria->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('empresarias.show',$empresaria->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('empresarias.edit',$empresaria->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $empresarias->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>