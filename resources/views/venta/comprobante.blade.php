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
            font-size: 12px;
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
            <p style="font-weight: bold" style="margin: 0;">N° Pedido: {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
            </p>
            <div>Fecha: {{ $venta->created_at->format('d-m-Y') }}</div>
            <div>Asesor: {{ $venta->vendedor->name }}</div>
        </div>
        <table style="width: 100%; margin-top: 5px; border-collapse: collapse;">
            <tr>
                <td style="width: 33.33%;">
                    <div class="col">
                        <span style="font-weight: bold">INFORMACIÓN EMPRESARIA</span>
                        <div>Nombre: {{ $empresaria->nombres . ' ' . $empresaria->apellidos }}</div>
                        <div>Cédula: {{ $empresaria->cedula }}</div>
                        <div>Teléfono: {{ $empresaria->telefono }}</div>
                        <div>Correo: {{ $empresaria->usuario->email }}</div>
                    </div>
                </td>
                <td style="width: 33.33%;">
                    <div class="col">
                        <span style="font-weight: bold">DATOS FACTURACIÓN</span>
                        <div>Nombre: {{ $venta->factura_nombres }}</div>
                        <div>Cédula: {{ $venta->factura_identificacion }}</div>
                        <div>Teléfono: {{ $empresaria->telefono }}</div>
                        <div>Correo: {{ $empresaria->usuario->email }}</div>
                    </div>
                </td>
                <td style="width: 33.33%;">
                    <div class="col">
                        <span style="font-weight: bold">DIRECCIÓN DE ENVIO</span>
                        <div>Nombre: {{ $venta->factura_nombres }}</div>
                        <div>Teléfono: {{ $empresaria->telefono }}</div>
                        <div>Dirección: {{ $venta->direccion_envio }}</div>
                        <div>Referencia: {{ $venta->observaciones }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; background-color: #f2f2f2;">FOTO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DESCRIPCION</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">COLOR</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">TALLA</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">PRECIO CATALOGO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DESCUENTO</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">CANTIDAD</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">PRECIO EMPRESARIA</th>
                    <th style="padding: 8px; background-color: #f2f2f2;">DIRECCION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td style="padding: 8px; text-align: center;padding: 8px;border: 1px solid black;"><img
                                width="60px"
                                src="{{ $pedido->imagen_path != '' ? 'https://catalogoibizza.com//storage/images/productos/' . $pedido->imagen_path : 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' }}">
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->nombre_producto }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->color_producto }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->talla_producto }}</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->precio * $pedido->cantidad }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;">0%</td>
                        <td style="padding: 8px;border: 1px solid black;">{{ $pedido->cantidad }}</td>
                        <td style="padding: 8px;border: 1px solid black;">${{ $pedido->precio * $pedido->cantidad }}
                        </td>
                        <td style="padding: 8px;border: 1px solid black;"></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="4"></td>
                    <td style="padding: 8px;border: 1px solid black;">
                        {{ $pedidos->sum(function ($pedido) {return $pedido->precio * $pedido->cantidad;}) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                    <td style="padding: 8px;border: 1px solid black;">
                        {{ $pedidos->sum(function ($pedido) {return $pedido->cantidad;}) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;">
                        {{ $pedidos->sum(function ($pedido) {return $pedido->precio * $pedido->cantidad;}) }}
                    </td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td colspan="9"  style="padding: 8px;border: 1px solid black;"></td>              
                </tr>

                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">ENVIO</td>
                    <td style="padding: 8px;border: 1px solid black;">$3</td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">TOTAL A PAGAR</td>
                    <td style="padding: 8px;border: 1px solid black;">{{ $pedidos->sum(function ($pedido) {return $pedido->precio * $pedido->cantidad;}) + 3}}</td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                </tr>
                <tr>
                    <td style="padding: 8px;border: 1px solid black;" colspan="6"></td>
                    <td style="padding: 8px;border: 1px solid black;">GANANCIA</td>
                    <td style="padding: 8px;border: 1px solid black;">$0</td>
                    <td style="padding: 8px;border: 1px solid black;"></td>
                </tr>
            </tfoot>
        </table>

</body>

</html>
