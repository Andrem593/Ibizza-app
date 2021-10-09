<x-app-layout>
    @section('title','Roles')
    
    <x-slot name="header">
        MANEJO DE ROLES
    </x-slot>
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route'=>'admin.roles.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'nombre') !!}
                    {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Ingrese el nombre del rol']) !!}
                </div>
                @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                <h2 class="h3">Lista de permisos</h2>

                @foreach ($permissions as $permission)
                    <div>
                        <label>
                            {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                            {{$permission->description}}
                        </label>
                    </div>
                @endforeach

                {!! Form::submit('Crear Rol', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>