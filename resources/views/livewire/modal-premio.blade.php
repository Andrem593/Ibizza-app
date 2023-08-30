<div wire:ignore.self class="modal fade" id="modal_premio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-ibizza">
                <div class="w-100 text-left">
                    @isset($premio)
                        <h5 class="bg-ibizza text-truncate">{{ $premio->descripcion }}</h5>
                    @endisset
                </div>
    
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                
                <div class="table-content cart-table-content">
                    <table class="w-100">
                        <thead class="text-center">
                            <tr>
                                <th>Producto</th>
                                <th>PVP</th>
                                <th>Precio Empresaria</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($premios)
                                @foreach ($premios as $item)
                                    <tr>
                                        <td data-label="Product" class="ec-cart-pro-name"><img class="ec-cart-pro-img mr-4"
                                                src="{{ empty($item->imagen_path) ? 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' : '../storage/images/productos/' . $item->imagen_path }}"
                                                alt="" width="80" height="80">{{ $item->nombre_mostrar }}</td>
                                        <td class="text-center">$ {{ $item->precio_empresaria }}</td>
                                        <td class="text-center"><span class="badge bg-ibizza">Gratis</span></td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
