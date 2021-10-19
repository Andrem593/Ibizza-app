@extends('layouts.app')

@section('template_title')
    {{ $empresaria->name ?? 'Show Empresaria' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Empresaria</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('empresarias.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Cedula:</strong>
                            {{ $empresaria->cedula }}
                        </div>
                        <div class="form-group">
                            <strong>Nombres:</strong>
                            {{ $empresaria->nombres }}
                        </div>
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {{ $empresaria->apellidos }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Nacimiento:</strong>
                            {{ $empresaria->fecha_nacimiento }}
                        </div>
                        <div class="form-group">
                            <strong>Direccion:</strong>
                            {{ $empresaria->direccion }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo Cliente:</strong>
                            {{ $empresaria->tipo_cliente }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $empresaria->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $empresaria->telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Id Ciudad:</strong>
                            {{ $empresaria->id_ciudad }}
                        </div>
                        <div class="form-group">
                            <strong>Vendedor:</strong>
                            {{ $empresaria->vendedor }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
