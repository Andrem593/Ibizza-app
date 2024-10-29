<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobande de Cambio</title>

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

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Esto hace que el div ocupe toda la altura de la ventana */
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="">
        <div style="float: right">
            <img src="{{ public_path('/assets/images/logo/logo_dpisar.png') }}"alt="Logo DPISAR" width="130px"
                style=" margin-bottom: 02px">
        </div>
        <div style="width: 45%; float: right">
            <div style= "margin: 0;">D'PISAR - VENTA POR CATÁLOGO</div>
        </div>
        {{--
        <div style="text-align: center">
            <img src="{{ public_path('/assets/images/logo/logo_dpisar.png') }}"alt="Logo DPISAR" width="200px"
                style="margin-bottom: 10px">
            <div style="width: 100%; text-align: center;">
                <div style="width: 500px; margin: 0 auto; text-align: center; font-size: 12px">
                    <div style="margin: 0;">Guayas-Guayaquil || 10 de Agosto y Pedro Carbo</div>
                    <div style="margin: 0;">Correo: servicioalcliente.catalogodpisar@zapecsa.com</div>
                    <div style="margin: 0;">Teléfono: 0963725427</div>
                </div>
            </div>
        </div>
        --}}

        <div style="width: 100%; text-align: left; margin-top: 20px">
            <div style="font-weight: bold" style="margin: 0;">N° Pedido: {{ str_pad($changeOrder->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div style="font-weight: bold" style="margin: 0;">N° Guia de Retorno: {{ $changeOrder->id_pedido }}</div>
            <div style="font-weight: bold" style="margin: 0;">N° Factura Venta: {{ $changeOrder->n_factura }}</div>
            <div style="font-weight: bold" style="margin: 0;">N° Factura: {{ $changeOrder->n_factura_carga }}</div>
            <div style="font-weight: bold" style="margin: 0;">Se va con Pedido: {{ $changeOrder->e_pedido }}</div>
            <div style="font-weight: bold" style="margin: 0;">Motivo Cambio: {{ $changeOrder->motivo }}</div>
            <div>Fecha: {{ $changeOrder->created_at->format('d-m-Y') }}</div>
            <div>Asesor: {{ $changeOrder->seller->name }}</div>
        </div>

        <table style="float:left; overflow: wrap; margin-top: 15px;">
            <tr>
                <td colspan="2">
                   <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                </td>
            </tr>
            <tr>
                <td style="width: 14%;"> <div>Identificación: </div> </td>
                <td> {{ $changeOrder->businesswomen->cedula }}</td>
            </tr>
            <tr>
                 <td> <div>Nombre: </div> </td>
                 <td> {{ $changeOrder->businesswomen->nombres . ' ' . $changeOrder->businesswomen->apellidos }}</td>
            </tr>
            <tr>
                <td> <div>Teléfono: </div> </td>
                <td> {{ $changeOrder->businesswomen->telefono }}</td>
            </tr>
            <tr>
                <td> <div>Correo: </div> </td>
               <td> {{ $changeOrder->businesswomen->usuario->email }}</td>
            </tr>
            {{-- <tr>
                 <td style="width: 33.33%;">
                            <div class="col">
                                <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                                <div>Nombre: {{ $changeOrder->businesswomen->nombres . ' ' . $changeOrder->businesswomen->apellidos }}</div>
                                <div>Identificación: {{ $changeOrder->businesswomen->cedula }}</div>
                                <div>Teléfono: {{ $changeOrder->businesswomen->telefono }}</div>
                                <div>Correo: {{ $changeOrder->businesswomen->usuario->email }}</div>
                            </div>
                        </td>
                <td style="width: 33.33%;">
                            <div class="col">
                                <span style="font-weight: bold">DATOS FACTURACIÓN</span>
                                <div>Nombre: {{ $changeOrder->factura_nombres }}</div>
                                <div>Identificación: {{ $changeOrder->factura_identificacion }}</div>
                                <div>Teléfono: {{ $changeOrder->telefono }}</div>
                                <div>Correo: {{ $changeOrder->email }}</div>
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
                <td> {{ $changeOrder->f_cedula }}</td>
            </tr>
            <tr>
                <td> <div>Nombre: </div> </td>
                <td> {{ $changeOrder->f_nombre }}</td>
            </tr>
            <tr>
                <td> <div>Teléfono: </div> </td>
                <td> {{ $changeOrder->f_telefono }}</td>
            </tr>
            <tr>
                <td> <div>Correo: </div> </td>
                <td> {{ $changeOrder->f_correo }}</td>
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
                    <td> {{ $changeOrder->e_cedula }}</td>
                </tr>
                <tr>
                    <td style="width: 14%;"> <div>Nombre: </div> </td>
                    <td> {{ $changeOrder->e_nombre }}</td>
                </tr>
                <tr>
                    <td> <div>Teléfono: </div> </td>
                    <td> {{ $changeOrder->e_telefono }}</td>
                </tr>
                <tr>
                    <td> <div>Provincia: </div> </td>
                    <td> {{ $changeOrder->province->descripcion }}</td>
                </tr>
                <tr>
                    <td> <div>Ciudad: </div> </td>
                    <td> {{ $changeOrder->city->descripcion }}</td>
                </tr>
                <tr>
                    <td> <div>Dirección: </div> </td>
                    <td> {{ $changeOrder->e_direccion }}</td>
                </tr>
                <tr>
                    <td> <div>Referencia: </div> </td>
                    <td> {{ $changeOrder->referencia }}</td>
                </tr>
                <tr>
                    <td> <div>Se va con pedido: </div> </td>
                    <td> {{ $changeOrder->e_pedido }}</td>
                </tr>
                <tr>
                    <td> <div>N° Aplica guia: </div> </td>
                    <td> {{ $changeOrder->id_pedido }}</td>
                </tr>
            </table>
        </div>

        <div class="center-content">
            <h6># DE VENTA: {{$changeOrder->id_venta}}</h6>
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
                    @foreach ($changeOrder->requestedChanges as $change)
                        <tr>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;">{{ $change->order->producto->sku }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->order->producto->descripcion }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->order->producto->color }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->order->producto->talla }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->precio_catalogo_producto_venta }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->descuento_venta * 100 }}%</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->cantidad_producto_venta }}</td>
                            <td style="padding: 8px;border: 1px solid black;">${{ $change->precio_producto_venta }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="center-content">
            <h6>REFERENCIAS DEL PRODUCTO QUE SE LE TIENE QUE ENVIAR A LA EMPRESARIA</h6>
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
                    @foreach ($changeOrder->requestedChanges as $change)
                        <tr>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;">{{ $change->product->sku }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->product->descripcion }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->product->color }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->product->talla }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->precio_catalogo }}</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->descuento * 100 }}%</td>
                            <td style="padding: 8px;border: 1px solid black;">{{ $change->cantidad }}</td>
                            <td style="padding: 8px;border: 1px solid black;">${{ $change->precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="4"></td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $changeOrder->requestedChanges->sum('precio_catalogo') }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;"></td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $changeOrder->requestedChanges->sum('cantidad') }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $changeOrder->requestedChanges->sum('precio') }}
                        </td>
                        {{-- <td style="padding: 8px;border: 1px solid black;"></td> --}}
                    </tr>
                    <tr>
                        <td colspan="8" style="padding: 8px;border: 1px solid black;"></td>
                    </tr>

                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">ENVIO</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $changeOrder->envio}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">TOTAL</td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $changeOrder->total }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                        <td style="padding: 8px;border: 1px solid black;">TOTAL PAGAR</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $changeOrder->total_pagar}}</td>
                    </tr>
                    <tr>
                        <td colspan="8" style="padding: 8px;border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;border: 1px solid black;" colspan="1">OBSERV.</td>
                        <td style="padding: 1px;border: 1px solid black;" colspan="7">
                            <textarea style="border:none ;height: auto; font-size: 11pt" readonly id="observacion_venta" rows="8">{{ $changeOrder->descripcion }}</textarea>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if(count($paymentsChange) > 0)
        <div style="display: block">
            <table style="margin-top: 15px; border-collapse: collapse;" width="100%">
                <thead>
                    <tr style="padding: 8px;border: 1px solid black;">
                        <th style="padding: 8px; background-color: #f2f2f2;">TIPO DE PAGO</th>
                        <th style="padding: 8px; background-color: #f2f2f2;">VALOR RECAUDADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentsChange as $pago)
                        <tr style="padding: 8px;border: 1px solid black;">
                            <td style="padding: 8px;border: 1px solid black;">{{ $pago->tipo_pago }}</td>
                            <td style="padding: 8px;border: 1px solid black; text-align: right">{{ $pago->valor_recaudado }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="padding: 8px;border: 1px solid black;">
                        <td style="padding: 8px;border: 1px; background-color: #f2f2f2;" > Total recaudado</td>
                        <td style="padding: 8px; border: 1px; background-color: #f2f2f2; text-align: right">{{ $paymentsChange->sum('valor_recaudado') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif



</body>

</html>
