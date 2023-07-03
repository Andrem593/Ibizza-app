<x-app-layout>
    @section('title', 'Crear Usuarios')
        <x-slot name="header">
            <h5 class="text-center">ADMINISTRACIÓN DE USUARIO</h5>
        </x-slot>

        <div class="recuadro mx-auto shadow">
            <div class="card-header bg-dark p-3">
                <h3 class="card-title">Creación nuevos usuarios</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('new.user') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Tipo de identificación</label>
                        <select class="form-select" name="tipoId" id="tipoId">
                            <option value="cedula">Cédula</option>
                            <option value="pasaporte">Pasaporte</option>
                            <option value="ruc">Ruc</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Identificación</label>
                        <input type="text" class="form-control" name="identificacion" placeholder="ingrese identificación"
                            value="{{ old('identificacion') }}">
                    </div>
                    @error('identificacion')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="name">Nombre Usuario</label>
                        <input type="text" class="form-control" name="name" placeholder="ingrese nombre de Usuario"
                            value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="email">Dirección de correo</label>
                        <input type="email" class="form-control" name="email" placeholder="ingresa tu correo"
                            value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="ingrese una contraseña"
                            value="{{ old('password') }}">
                    </div>
                    @error('password')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="role" class="form-label">Tipo de Usuario</label>
                        <select name="role" class="form-control" >
                            @foreach ($roles as $role )
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>                   
                    </div>
                    @error('role')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <div class="mx-2">
                        <a href="{{URL::previous()}}" class="btn btn-ibizza text-white">Volver</a>
                    </div>
                    <div>                        
                        <button type="submit" class="btn btn-dark">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </x-app-layout>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    @if (session('message'))
        <script>
            Toast.fire({
                icon: 'success',
                title: 'Nuevo usuario creado'
            })
        </script>
    @endif
