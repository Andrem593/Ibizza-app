<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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
            <img src="{{ public_path('/assets/images/logo/logo_dpisar.png') }}" alt="Logo Ibizza" width="200px"
                style="margin-bottom: 10px">
            <div style="width: 100%; text-align: center;">
                <div style="width: 500px; margin: 0 auto; text-align: center; font-size: 12px">
                    <div style="margin: 0;">Guayas-Guayaquil || 10 de Agosto y Pedro Carbo</div>
                    <div style="margin: 0;">Correo: servicioalcliente.catalogodpisar@zapecsa.com</div>
                    <div style="margin: 0;">Teléfono: 0963725427</div>
                </div>
            </div>
        </div>

        <div style="width: 100%; text-align: left; margin-top: 20px">
            <table>
                <tr>
                    <td><div>N° Cambio: </div></td>
                    <td style="width: 15%;">{{ $reserveChangeOrder->id }}</td>
                </tr>
                <tr>
                    <td><div>Fecha:</div></td>
                    <td>{{ $reserveChangeOrder->created_at->format('d-m-Y') }}</td>
                </tr>
            </table>
            {{-- <div style="font-weight: bold" style="margin: 0;">N° Pedido: {{ $reservas->id }}</div>
            <div>Fecha: </div> --}}
        </div>
        <table style="width: 100%; margin-top: 5px; border-collapse: collapse;">
            <tr>
                <tr>
                    <td colspan="2">
                       <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                    </td>
                </tr>
                <tr>
                    <td><div>Nombre</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->nombre_completo}}</td>
                </tr>
                <tr>
                    <td style="width: 14%;"><div>Identificación</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->cedula }}</td>
                </tr>
                <tr>
                    <td><div>Teléfono</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->telefono }}</td>
                </tr>
                <tr>
                    <td><div>Correo</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->usuario->email }}</td>
                </tr>
                <tr>
                    <td><div>Provincia</div></td>
                    <td>{{ @$reserveChangeOrder->province->descripcion }}</td>
                </tr>
                <tr>
                    <td><div>Ciudad</div></td>
                    <td>{{ @$reserveChangeOrder->city->descripcion }}</td>
                </tr>
                <tr>
                    <td><div>Dirección</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->direccion }}</td>
                </tr>
                <tr>
                    <td><div>Referencia</div></td>
                    <td>{{ $reserveChangeOrder->businesswoman->referencia }}</td>
                </tr>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; background-color: #f2f2f2;">SKU</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DESCRIPCIÓN</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">COLOR</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">TALLA</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">P.V.C</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">CANT.</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DESC.</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">P.V.E</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reserveChangeOrder->reservedChangeDetail as $reservedChangeDetail)
                    <tr>
                        {{-- <td style="padding: 8px; text-align: center;padding: 8px;border: 1px solid black;">
                            <img
                                width="60px"
                                src="{{ $pedido->producto->imagen_path != '' ? 'https://catalogoibizza.com//storage/images/productos/' . $pedido->producto->imagen_path : 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' }}">
                        </td> --}}
                        <td style="padding: 8px; text-align: center;padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->product->sku }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->product->descripcion }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->product->color }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->product->talla }}</td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $reservedChangeDetail->precio_catalogo}}
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->cantidad }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->descuento * 100 }}%</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $reservedChangeDetail->total}}
                        </td>
                    </tr>
                    @if ($reservedChangeDetail->e_nombre != '')
                    <tr>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;"></td>
                            <td style="padding: 8px; text-align: center;padding: 8px; border: 1px solid black;" colspan="7">

                                <table>
                                    <tr>
                                        <td>Identificación: </td>
                                        <td>{{ $reservedChangeDetail->e_cedula }} </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre: </td>
                                        <td>{{ $reservedChangeDetail->e_nombre }} </td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono: </td>
                                        <td>{{ $reservedChangeDetail->e_telefono }}</td>
                                    </tr>
                                    <tr>
                                        <td> Dirección: </td>
                                        <td>{{ $reservedChangeDetail->e_direccion }}</td>
                                   </tr>
                                    <tr>
                                        <td> Referencia: </td>
                                        <td>{{ $reservedChangeDetail->observaciones }}</td>
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
                        ${{ $reserveChangeOrder->reservedChangeDetail->sum('precio_catalogo') }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;">
                        {{ $reserveChangeOrder->reservedChangeDetail->sum('cantidad')  }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{ number_format($reserveChangeOrder->reservedChangeDetail->sum('precio') ,2) }}
                    </td>

                    {{-- <td style="padding: 8px;border: 1px solid black;"></td> --}}
                </tr>
                <tr>
                    <td colspan="8" style="padding: 8px;border: 1px solid black;"></td>
                </tr>

                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">ENVIO</td>
                    <td style="padding: 8px;border: 1px solid black;">${{ $reserveChangeOrder->envio }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">TOTAL A PAGAR</td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{ $reserveChangeOrder->total_pagar }}
                    </td>

                </tr>
                {{-- <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">GANANCIA</td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{number_format( $pedidos_pendientes->sum(function ($pedido) {
                            return $pedido->precio_empresaria * $pedido->cantidad;
                        }) -
                            $pedidos_pendientes->sum(function ($pedido) {
                                return $pedido->total;
                            }),2) }}
                    </td>

                </tr> --}}
            </tfoot>
        </table>

        <div style="margin-top: 20px">
            <img src="{{ public_path('assets/images/cuentas/Cuentas.jpg')}}" height="300" width="650">
        </div>

</body>

</html>
