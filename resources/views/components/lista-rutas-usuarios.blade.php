<div class="ec-sidebar-block">
    <div class="ec-vendor-block">
        <div class="ec-vendor-block-bg"></div>
        <div class="ec-vendor-block-detail">
            <img class="v-img" src="{{ Auth::user()->profile_photo_url }}" alt="vendor image">
            <h5>{{Auth::user()->name}}</h5>
        </div>
        <div class="ec-vendor-block-items">
            <ul>
                <li><a href="{{ route('web.perfil-empresaria') }}">Perfil</a></li>
                <li><a href="{{ route('web.tomar-pedido')}}">Realizar Pedidos</a></li>
                <li><a href="{{ route('web.pedidos-guardados')}}">Pedidos Reservados</a></li>
                <li><a href="{{ route('web.historial-compras') }}">Historial de Compras</a></li>
                <li><a href="{{ route('web.seguimiento-pedidos')}}">Seguimiento de Pedidos</a></li>
                {{-- <li><a href="{{ route('web.carro-compras') }}">Carrito</a></li> --}}
                <li><a href="{{ route('web.checkout') }}">Liquidar Pedido</a></li>
            </ul>
        </div>
    </div>
</div>