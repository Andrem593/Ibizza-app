<div wire:ignore.self class="modal fade" id="modal_premio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <button type="button" class="btn-close qty_close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">

                <div class="table-content cart-table-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($premios)
                                @foreach ($premios as $item)
                                    <tr>
                                        <td data-label="Product" class="ec-cart-pro-name"><img class="ec-cart-pro-img mr-4"
                                                src="{{ '../storage/images/productos/' . $item->imagen_path }}"
                                                alt="">{{ $item->nombre_mostrar }}</td>
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
