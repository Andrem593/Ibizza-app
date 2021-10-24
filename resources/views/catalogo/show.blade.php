@extends('layouts.app')

@section('template_title')
    {{ $catalogo->name ?? 'Show Catalogo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Catalogo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('catalogos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $catalogo->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $catalogo->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Foto Path:</strong>
                            {{ $catalogo->foto_path }}
                        </div>
                        <div class="form-group">
                            <strong>Pdf Path:</strong>
                            {{ $catalogo->pdf_path }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Publicacion:</strong>
                            {{ $catalogo->fecha_publicacion }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Fin Catalogo:</strong>
                            {{ $catalogo->fecha_fin_catalogo }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $catalogo->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Premio Id:</strong>
                            {{ $catalogo->premio_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
