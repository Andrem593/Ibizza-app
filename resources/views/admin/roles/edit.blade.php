<x-app-layout>
    @section('title','Roles')
    
    <x-slot name="header">
        MANEJO DE ROLES
    </x-slot>
    @if (session('info'))
        <div class="alert alert-success">
            {{session('info')}}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($role,['route'=> ['admin.roles.update', $role],'method'=>'put']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Nombre del Rol') !!}
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

                {!! Form::submit('Editar Rol', ['class'=>'btn btn-ibizza']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>