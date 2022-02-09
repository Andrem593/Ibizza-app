<x-app-layout>
    @section('title', 'Dashboard')
        <x-slot name="header" class="m-0">
            <div class="card p-2">
                <div class="row d-flex justify-content-start py-2">
                    <div class="col-lg-6 col-md-6">
                        <h2 class="font-weight-bold mb-0">Hola 👋 {{ Auth::user()->name }}</h2>
                        <p class="lead text-muted">Revisa la última información</p>
                    </div>
                </div>
            </div>
        </x-slot>
        {{-- seccion de cards de informacion principal  --}}
        <div class="row">
            <div class="col">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shoe-prints"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Ventas Catalogo</span>
                        <span class="info-box-number">
                            {{$ventaCatalogo}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Productos</span>
                        <span class="info-box-number">{{$productos}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <div class="col">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Ventas</span>
                        <span class="info-box-number">{{$ventas}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Empresarias</span>
                        <span class="info-box-number">{{$empresarias}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        {{-- seccion de graficos con metas --}}
        <div class="row">
            
            
        </div>
    </x-app-layout>
    <script>

    </script>
