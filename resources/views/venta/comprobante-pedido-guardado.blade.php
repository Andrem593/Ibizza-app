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

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="">
        <div style="text-align: center">
            <img src="{{ url('/assets/images/logo/Logo_ibizza.svg') }}" alt="Logo Ibizza" width="120px"
                style="margin-bottom: 10px">
            <div style="width: 100%; text-align: center;">
                <div style="width: 240px; margin: 0 auto; text-align: center; font-size: 12px">
                    <p style="margin: 0;">Guayas-Guayaquil || Chile 315 y Luque, Centro Guayaquil</p>
                    <p style="margin: 0;">Correo: servicioalcliente@zapecsa.com</p>
                    <p style="margin: 0;">Teléfono: 0963725427</p>
                </div>
            </div>
        </div>

        <div style="width: 100%; text-align: left; margin-top: 20px">
            <p style="font-weight: bold" style="margin: 0;">N° Pedido: {{ $reservas->id }}
            </p>
            <div>Fecha: {{ $reservas->created_at->format('d-m-Y') }}</div>
        </div>
        <table style="width: 100%; margin-top: 5px; border-collapse: collapse;">
            <tr>
                <td>
                    <div class="col">
                        <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                        <div>Nombre: {{ $reservas->empresaria->nombres . ' ' . $reservas->empresaria->apellidos }}</div>
                        <div>Cédula: {{ $reservas->empresaria->cedula }}</div>
                        <div>Teléfono: {{ $reservas->empresaria->telefono }}</div>
                        <div>Correo: {{ $reservas->empresaria->usuario->email }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; background-color: #f2f2f2;">FOTO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">PRODUCTO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">COLOR</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">TALLA</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">PRECIO CATÁLOGO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">PRECIO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DESCUENTO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">CANTIDAD</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DIRECCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos_pendientes as $pedido)
                    <tr>
                        <td style="padding: 8px; text-align: center;padding: 8px;border: 1px solid black;"><img
                                width="60px"
                                src="{{ $pedido->producto->imagen_path != '' ? 'https://catalogoibizza.com//storage/images/productos/' . $pedido->producto->imagen_path : 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' }}">
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->producto->descripcion }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->producto->color }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->producto->talla }}</td>
                        <td style="padding: 8px;border: 1px solid black;">
                            {{ $pedido->precio_empresaria * $pedido->cantidad }}
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->total}}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->descuento * 100 }}%</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->cantidad }}</td>
                        <td style="padding: 8px;border: 1px solid black;">
                            @php
                                if ($pedido->direccion_envio != '') {
                                    $data = json_decode($pedido->direccion_envio);
                                    echo "Nombre: $data->nombre <br> Tel: $data->telefono <br> Dir: $data->direccion <br> Ref: $data->referencia";
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="4"></td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{ $pedidos_pendientes->sum(function ($pedido) {return $pedido->precio_empresaria * $pedido->cantidad;}) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{ number_format($pedidos_pendientes->sum(function ($pedido) {return $pedido->total;}),2) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                    <td style="padding: 8px;border: 1px solid black;">
                        {{ $pedidos_pendientes->sum(function ($pedido) {return $pedido->cantidad;}) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td colspan="9" style="padding: 8px;border: 1px solid black;"></td>
                </tr>

                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="7"></td>
                    <td style="padding: 8px;border: 1px solid black;">ENVIO</td>
                    <td style="padding: 8px;border: 1px solid black;">${{ $reservas->envio }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="7"></td>
                    <td style="padding: 8px;border: 1px solid black;">TOTAL A PAGAR</td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{ $pedidos_pendientes->sum(function ($pedido) {return $pedido->total;}) + $reservas->envio }}
                    </td>

                </tr>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="7"></td>
                    <td style="padding: 8px;border: 1px solid black;">GANANCIA</td>
                    <td style="padding: 8px;border: 1px solid black;">
                        ${{number_format( $pedidos_pendientes->sum(function ($pedido) {
                            return $pedido->precio_empresaria * $pedido->cantidad;
                        }) -
                            $pedidos_pendientes->sum(function ($pedido) {
                                return $pedido->total;
                            }),2) }}
                    </td>

                </tr>
            </tfoot>
        </table>


        <div style="margin-top: 20px">
            <img src="https://catalogoibizza.com/public/assets/images/cuentas/Cuentas.jpg" style="width: 100%">
        </div>

</body>

</html>
