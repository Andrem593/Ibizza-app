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
                        <label for="name">Nombre Usuario</label>
                        <input type="text" class="form-control" name="name" placeholder="ingrese nombre de Usuario">
                    </div>
                    @error('name')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="email">Dirección de correo</label>
                        <input type="email" class="form-control" name="email" placeholder="ingresa tu correo">
                    </div>
                    @error('email')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="ingrese una contraseña">
                    </div>
                    @error('password')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="form-group">
                        <label for="role" class="form-label">Tipo de Usuario</label>
                        <input class="form-control" list="opciones_usuario" id="role" name="role"
                            placeholder="Escribe el tipo de usuario...">
                        <datalist id="opciones_usuario">
                            <option value="Administrador">
                            <option value="Vendedor">
                            <option value="Supervisor">
                            <option value="Empresaria">
                        </datalist>
                    </div>
                    @error('role')
                        <div class="alert alert-danger p-1" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark">Registrar</button>
                </div>
            </form>
        </div>
    </x-app-layout>
    @isset($user)
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

            Toast.fire({
                icon: 'success',
                title: 'Usuario creado'
            })

        </script>
    @endisset
