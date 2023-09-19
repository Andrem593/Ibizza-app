<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobande de Venta</title>

    <style>
        * {
            font-family: sans-serif;
            font-size: 10px;
        }
        div, span{
            font-family: sans-serif;
            font-size: 14px;
        }
        /**table{
            width: 100%; 
            margin-top: 5px; 
            border-collapse: collapse;"
        } **/
        td{
            font-size: 12px;
        }
       
    </style>
</head>

<body>
    <div class="">
        <div style="text-align: center">
            <img src="{{ url('/assets/images/logo/Logo_ibizza.svg') }}" alt="Logo Ibizza" width="120px"
                style="margin-bottom: 10px">
            <div style="width: 100%; text-align: center;">
                <div style="width: 500px; margin: 0 auto; text-align: center; font-size: 12px">
                    <div style="margin: 0;">Guayas-Guayaquil || Chile 315 y Luque - Centro Guayaquil</div>
                    <div style="margin: 0;">Correo: servicioalcliente@zapecsa.com</div>
                    <div style="margin: 0;">Teléfono: 0963725427</div>
                </div>
            </div>
        </div>

        <div style="width: 100%; text-align: left; margin-top: 20px">
            <div style="font-weight: bold" style="margin: 0;">N° Pedido: {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div style="font-weight: bold" style="margin: 0;">N° Factura: {{ $venta->n_factura }}</div>
            <div style="font-weight: bold" style="margin: 0;">N° Guia: {{ $venta->n_guia }}</div>
            <div>Fecha: {{ $venta->created_at->format('d-m-Y') }}</div>
            <div>Asesor: {{ $venta->vendedor->name }}</div>
        </div>
        
        <table style="float:left; overflow: wrap; margin-top: 15px;">
            <tr>
                <td colspan="2">
                   <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                </td>
            </tr>
            <tr>
                <td style="width: 14%;"> <div>Identificación: </div> </td>
                <td> {{ $empresaria->cedula }}</td>
            </tr>
            <tr>
                 <td> <div>Nombre: </div> </td>
                 <td> {{ $empresaria->nombres . ' ' . $empresaria->apellidos }}</td>
            </tr>
            <tr>
                <td> <div>Teléfono: </div> </td>
                <td> {{ $empresaria->telefono }}</td>
            </tr>
            <tr>
                <td> <div>Correo: </div> </td>
               <td> {{ $empresaria->usuario->email }}</td>
            </tr>
            {{-- <tr>
                 <td style="width: 33.33%;">
                            <div class="col">
                                <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                                <div>Nombre: {{ $empresaria->nombres . ' ' . $empresaria->apellidos }}</div>
                                <div>Identificación: {{ $empresaria->cedula }}</div>
                                <div>Teléfono: {{ $empresaria->telefono }}</div>
                                <div>Correo: {{ $empresaria->usuario->email }}</div>
                            </div>
                        </td>
                <td style="width: 33.33%;">
                            <div class="col">
                                <span style="font-weight: bold">DATOS FACTURACIÓN</span>
                                <div>Nombre: {{ $venta->factura_nombres }}</div>
                                <div>Identificación: {{ $venta->factura_identificacion }}</div>
                                <div>Teléfono: {{ $venta->telefono }}</div>
                                <div>Correo: {{ $venta->email }}</div>
                            </div>
                        </td>
            </tr> --}}
       </table>
                
        <table style="float:right; overflow: wrap; margin-top: 15px;">
            <tr>
                <td colspan="2">
                    <span style="font-weight: bold">DATOS FACTURACIÓN</span>
                </td>
            </tr>
            <tr>
                <td style="width: 14%;"> <div>Identificación: </div> </td>
                <td> {{ $venta->factura_identificacion }}</td>
            </tr>
            <tr>
                <td> <div>Nombre: </div> </td>
                <td> {{ $venta->factura_nombres }}</td>
            </tr>
            <tr>
                <td> <div>Teléfono: </div> </td>
                <td> {{ $venta->telefono }}</td>
            </tr>
            <tr>
                <td> <div>Correo: </div> </td>
                <td> {{ $venta->email }}</td>
            </tr>
       </table>

        <div style="display: block">
            <table style="margin-top: 130px; border-collapse: collapse; overflow: wrap;" width="100%">
                <tr>
                    <td colspan="2">
                        <span style="font-weight: bold">DIRECCIÓN DE ENVIO</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 14%;"> <div>Identificación: </div> </td>
                    <td> {{ $direccionVenta->identificacion }}</td>
                </tr>
                <tr>
                    <td style="width: 14%;"> <div>Nombre: </div> </td>
                    <td> {{ $direccionVenta->nombre }}</td>
                </tr>
                <tr>
                    <td> <div>Teléfono: </div> </td>
                    <td> {{ $direccionVenta->telefono }}</td>
                </tr>
                <tr>
                    <td> <div>Provincia: </div> </td>
                    <td> {{ $direccionVenta->ciudad->provincia->descripcion }}</td>
                </tr>
                <tr>
                    <td> <div>Ciudad: </div> </td>
                    <td> {{ $direccionVenta->ciudad->descripcion }}</td>
                </tr>
                <tr>
                    <td> <div>Dirección: </div> </td>
                    <td> {{ $direccionVenta->direccion }}</td>
                </tr>
                <tr>
                    <td> <div>Referencia: </div> </td>
                    <td> {{ $direccionVenta->referencia }}</td>
                </tr>
            </table>
        </div>
        
        
        <div style="display: block">
            <table style="margin-top: 15px; border-collapse: collapse;" width="100%">
                <thead>
                    <tr>
                        <th style="padding: 8px; background-color: #f2f2f2;">SKU</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">DESCRIPCION</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">COLOR</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">TALLA</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">P.V.C</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">DESC.</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">CANT.</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">P.V.E</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;">{{ $pedido->sku }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->nombre_producto }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->color_producto }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->talla_producto }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->precio_catalogo }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->descuento }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $pedido->cantidad }}</td>
                            <td style="padding: 8px;border: 1px solid black;">${{ $pedido->precio }}</td>
                        </tr>
                        @if ($pedido->direccion_envio != '')
                        <tr>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;"></td>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;" colspan="7">
                                 @php
                                    $data = json_decode($pedido->direccion_envio);
                                @endphp
                                                                        
                                <table>
                                    <tr>
                                        <td>Identificación: </td>
                                        <td>{{ $data->identificacion }} </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre: </td>
                                        <td>{{ $data->nombre }} </td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono: </td>
                                        <td>{{ $data->telefono }}</td>
                                    </tr>
                                    <tr>
                                        <td> Dirección: </td>
                                        <td>{{ $data->direccion }}</td>
                                   </tr>
                                    <tr>
                                        <td> Referencia: </td>
                                        <td>{{ $data->referencia }}</td>
                                    </tr>
                                </table>
                                {{-- echo "Nombre: $data->nombre <br> Tel: $data->telefono <br> Dir: $data->direccion <br> Ref: $data->referencia"; --}}       
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="4"></td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $pedidos->sum(function ($pedido) {return $pedido->precio_catalogo;}) }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;"></td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $pedidos->sum(function ($pedido) {return $pedido->cantidad;}) }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $pedidos->sum(function ($pedido) {return $pedido->precio;}) }}
                        </td>
                        {{-- <td style="padding: 8px;border: 1px solid black;"></td> --}}
                    </tr>
                    <tr>
                        <td colspan="8" style="padding: 8px;border: 1px solid black;"></td>
                    </tr>
    
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">ENVIO</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $venta->envio}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">TOTAL A PAGAR</td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $pedidos->sum(function ($pedido) { return $pedido->precio; }) + $venta->envio }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">GANANCIA</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $venta->total_p_empresaria}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" style="padding: 8px;border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="1">OBSERV.</td>
                        <td style="padding: 1px;border: 1px solid black;" colspan="7">
                            <textarea style="border:none ;height: 120px; font-size: 11pt" readonly id="observacion_venta" rows="8">{{ $venta->observaciones }}</textarea>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        @if(count($pagos) > 0)
        <div style="display: block">
            <table style="margin-top: 15px; border-collapse: collapse;" width="100%">
                <thead>
                    <tr style="padding: 8px;border: 1px solid black;">
                        <th style="padding: 8px; background-color: #f2f2f2;">TIPO DE PAGO</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">VALOR RECAUDADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr style="padding: 8px;border: 1px solid black;">
                            <td style="padding: 8px;border: 1px solid black;">{{ $pago->tipo_pago }}</td>
                            <td style="padding: 8px;border: 1px solid black; text-align: right">{{ $pago->valor_recaudado }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="padding: 8px;border: 1px solid black;">
                        <td style="padding: 8px;border: 1px; background-color: #f2f2f2;" > Total recaudado</td>
                        <td style="padding: 8px; border: 1px; background-color: #f2f2f2; text-align: right">{{ $valorRecaudadoTotal }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
        

        @if (!empty($empresaria))
            @if (count($empresaria->pedidos) == 1)
                <hr />
                <div style="width: 100%; text-align: right;margin-top: 20px">
                    <label style="padding: 8px;border: 1px solid black; width: 200px; margin-top: 20px">
                        Enviar catálogo
                    </label>
                </div>
            @endif
        @endif


</body>

</html>
