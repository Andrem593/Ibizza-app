@extends('layouts.app')

@section('template_title')
    {{ $premio->name ?? 'Show Premio' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Premio</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('premios.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Condicion:</strong>
                            {{ $premio->condicion }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $premio->descripcion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
