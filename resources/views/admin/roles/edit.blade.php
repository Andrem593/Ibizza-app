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
                <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3 p-2">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Productos
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'productos')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Catalogos
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'catalogos')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Ventas
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'ventas')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>   
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Usuarios
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'usuarios')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>      
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Productos
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'reportes')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>  
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header bg-ibizza">
                                Modulo Inicial
                            </div>
                            <div class="card-body">
                                @foreach ($permissions as $permission)
                                @if ($permission->categoria == 'web')
                                <div>
                                    <label>
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=> 'me-1']) !!}
                                        {{$permission->description}}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>       
                </div>
                {!! Form::submit('EDITAR ROL', ['class'=>'btn btn-ibizza w-100']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>