<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Empresaria;
use App\Mail\Contacto;
use App\Mail\RegistroEmpresaria;
use App\Models\DireccionVenta;
use App\Models\Pedido;
use App\Models\Separado;
use App\Models\Venta;
use App\Premio;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;
use Cart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class webController extends Controller
{
    public function __invoke()
    {
        $reservados = [];
        if (!empty(Auth::user())) {
            $reservados = Separado::where('id_usuario', Auth::user()->id)->get();
        }
        $marcas = DB::table('marcas')->where('imagen', '<>', '')->where('estado', '=', 'A')->get();
        $catalogos = DB::table('catalogos')->where('estado', '=', 'PUBLICADO')->get();
        return view('welcome2', compact('marcas', 'catalogos', 'reservados'));
    }

    public function deleteToCart(Request $request)
    {
        Cart::remove($request->id);
        $response = [
            'message' => 'deleted',
            'subtotal' => Cart::subtotal(),
            'tax' => Cart::tax(),
            'total' => Cart::total()
        ];
        json_encode($response);
        return $response;
    }

    public function checkout_view(Request $request)
    {
        $empresariaId = $request->id ?? null;
        $catalogos = Catalogo::where('estado', 'PUBLICADO')->get();
        $envio = $request->envio ?? 0;
        $condiciones = [];
        $productoPremio = [];
        $empresaria = new Empresaria();
        $provincia = DB::table('provincias')->where('estado', 'A')->get();
        $ciudad = '';
        $flagPremioEmpresaria = 0;
        $flagPremioPedido = 0;
        $contPremio = 0;
        $contRegla = 0;
        // foreach ($catalogos as $catalogo) {
        //     $condiciones[] = Premio::where('catalogo_id', $catalogo->id)->get();
        // }

        if (!empty(Auth::user())) {
            if (!empty($empresariaId)) {
                $empresaria = Empresaria::with('pedidos')
                    ->select('empresarias.*', 'ciudades.provincia_id', 'users.email as email',)
                    ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
                    ->join('users', 'users.id', '=', 'empresarias.id_user')
                    ->where('empresarias.id', $empresariaId)->first();
                if (!empty($condiciones)) {
                    foreach ($condiciones as $key => $condicion) {
                        foreach ($condicion as $i => $value) {
                            $reglas = json_decode($value->condicion);
                            foreach ($reglas as $itemRegla) {
                                if ($itemRegla->nombre_tabla == 'empresarias') {
                                    if (!$flagPremioEmpresaria) {
                                        $valores = explode(' ', $itemRegla->condicion);
                                        $estado = '"' . $valores[2] . '"';
                                        //$premio = DB::table($itemRegla->nombre_tabla)->whereRaw("'".$valores[0]." ".$valores[1]." ".$estado."'")->get();
                                        $premio = DB::table($itemRegla->nombre_tabla)->whereRaw($itemRegla->condicion)->get();
                                        foreach ($premio as  $val) {
                                            if ($val->id_user == $empresaria->id_user) {
                                                $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)
                                                    ->where('productos.estado', 'A')
                                                    ->where('productos.stock', '>', 0)
                                                    ->groupBy('productos.estilo')->get();
                                                foreach ($producto as  $value) {
                                                    $colores = Producto::where('estilo', $value->estilo)
                                                        ->where('estado', 'A')
                                                        ->where('stock', '>', 0)->groupBy('color')->get('color');
                                                    $colores2 = [];
                                                    foreach ($colores as  $color) {
                                                        array_push($colores2, $color->color);
                                                    }
                                                    $value->colores = $colores2;
                                                    $tallas = Producto::where('estilo', $value->estilo)
                                                        ->where('estado', 'A')
                                                        ->where('stock', '>', 0)->groupBy('talla')->get('talla');
                                                    $tallas2 = [];
                                                    foreach ($tallas as $talla) {
                                                        array_push($tallas2, $talla->talla);
                                                    }
                                                    $value->tallas = $tallas2;
                                                    array_push($productoPremio, $value);
                                                }
                                                //$json['premios'] = $productoPremio;
                                                $flagPremioEmpresaria = 1;
                                                $contPremio++;
                                            }
                                        }
                                    }
                                }
                                if ($itemRegla->nombre_tabla == 'pedidos') {
                                    $rule = $itemRegla->condicion;
                                    $total_factura = Cart::total();
                                    $rule  = str_replace('total_factura', $total_factura, $rule);

                                    $valores = explode(' ', $rule);
                                    $dbValor = str_replace("'", "", $valores[2]);
                                    if ($valores[1] == '>') {
                                        if ($total_factura > $dbValor) {
                                            $flagPremioPedido = 1;
                                        }
                                    } elseif ($valores[1] == '>=') {
                                        if ($total_factura >= $dbValor) {
                                            $flagPremioPedido = 1;
                                        }
                                    }

                                    if ($flagPremioPedido) {
                                        $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')
                                            ->where('productos.estado', 'A')
                                            ->where('productos.stock', '>', 0)
                                            ->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                                        foreach ($producto as  $value) {
                                            $colores = Producto::where('estilo', $value->estilo)->groupBy('color')
                                                ->where('estado', 'A')
                                                ->where('stock', '>', 0)
                                                ->get('color');
                                            $colores2 = [];
                                            foreach ($colores as  $color) {
                                                array_push($colores2, $color->color);
                                            }
                                            $value->colores = $colores2;
                                            $tallas = Producto::where('estilo', $value->estilo)
                                                ->where('estado', 'A')
                                                ->where('stock', '>', 0)
                                                ->groupBy('talla')
                                                ->get();
                                            $tallas2 = [];
                                            foreach ($tallas as $talla) {
                                                array_push($tallas2, $talla->talla);
                                            }
                                            $value->tallas = $tallas2;
                                            array_push($productoPremio, $value);
                                        }
                                        $contPremio++;
                                    }
                                    //pendiente validar por total de factura
                                }
                                $contRegla++;
                            }
                            if ($contPremio == $contRegla) {
                                $productoPremio;
                            } else {
                                $productoPremio = [];
                            }
                            $contPremio = 0;
                            $contRegla = 0;
                            $flagPremioEmpresaria = 0;
                            $flagPremioPedido = 0;
                        }
                    }
                }

                $ciudad = DB::table('ciudades')->where('provincia_id', $empresaria->provincia_id)->where('estado', 'A')->get();
            }
        }
        return view('ecomerce.checkout', compact('productoPremio', 'empresaria', 'provincia', 'ciudad', 'envio'));
    }
    public function dataCheckout(Request $request)
    {
        if (isset($request->premios)) {
            $premios = $request->premios;
            if (count($premios) > 0) {
                foreach ($premios as $val) {
                    $pro = Producto::where('estilo', $val['estilo'])->where('talla', $val['talla'])->where('color', $val['color'])->first();
                    if ($pro->stock - 1 >= 0) {
                        $pro->stock = $pro->stock - 1;
                        $pro->save();
                        Cart::add($pro->id, $pro->descripcion, 1, 0, ['image' => $pro->imagen_path])->associate('App\Models\Producto');
                    }
                }
            }
        }
        $catalogo = Catalogo::select('id')->where('estado', 'PUBLICADO')->first();
        $productos_pedidos = Cart::content();
        $id_pedidos = '';
        $empresaria = Empresaria::where('cedula', $request->cedulaEmpresaria)->first();
        if (empty($request->observaciones)) {
            $request->observaciones = 'SIN OBSERVACIONES';
        }

        Empresaria::find($empresaria->id);

        $envio = str_replace('$', '', $request->envio);
        $venta = Venta::create([
            'id_vendedor' => $empresaria->vendedor,
            'id_catalogo' => $catalogo->id, //leidy 
            'id_empresaria' => $empresaria->id,
            'factura_identificacion' => $request->cedula,
            'factura_nombres' => ($request->nombres . ' ' . $request->apellidos),
            'direccion_envio' => $request->direccion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'cantidad_total' => Cart::count(),
            'envio' => $envio,
            'total_venta' => $request->total_pagar,
            'total_p_empresaria' => $request->ganancia,
            'estado' => 'PENDIENTE DE PAGO',
            'observaciones' => $request->observaciones
        ]);
        try {
            DireccionVenta::create([
                'id_venta' => $venta->id,
                'identificacion' => $request->identificacion_envio, //Se guarda la identificación en las direccion de envío seleccionada
                'nombre' => $request->nombre_envio,
                'telefono' => $request->telefono_envio,
                'direccion' => $request->direccion_envio,
                'referencia' => $request->referencia_envio,
                'ciudad_id' => $request->ciudad,
            ]);

            foreach ($productos_pedidos as $producto) {
                $pro = Producto::where('id', $producto->id)->first();
                $precioCatalogo = floatval(str_replace(',', '', (number_format($producto->options->pCatalogo * $producto->qty, 2))));

                $precio = $precioCatalogo - ($precioCatalogo * $producto->options->descuento);
                $precio = round($precio, 2);

                $pedido = Pedido::create([
                    'id_producto' => $producto->id,
                    'id_venta' => $venta->id,
                    'cantidad' => $producto->qty,
                    'precio' => $precio,
                    'precio_catalogo' => floatval(str_replace(',', '', (number_format($producto->options->pCatalogo * $producto->qty, 2)))),
                    'direccion_envio' => $producto->options->dataEnvio != '' ? $producto->options->dataEnvio : '',
                    'descuento' => $producto->options->descuento,
                    'estado' => 'PENDIENTE DE PAGO',
                    'usuario' => Auth::user()->id,
                ]);
                Producto::where('id', $producto->id);
                $id_pedidos .= $pedido->id . '|';
            }
            Venta::where('id', $venta->id)->update([
                'id_pedidos' => $id_pedidos
            ]);
            Cart::destroy();
            $response = [];
            if (!empty($venta)) {
                $response['id_venta'] = $venta->id;
            }
            if ($empresaria->tipo_cliente == 'NUEVA') {
                // $catActual = Catalogo::where('estado', 'PUBLICADO')->get();
                // $catIds = Catalogo::where('estado', 'PUBLICADO')->pluck('id')->toArray();    
                // $catAntIds = [];       
                // foreach ($catActual as $key => $cat) {
                //     $fechaInicio = date('Y-m-d', strtotime($cat->fecha_publicacion));
                //     $fechaPublicacion = new DateTime($cat->fecha_publicacion);
                //     $fechaPublicacion->sub(new DateInterval('P15D'));
    
                //     $fechaFin = $fechaPublicacion->format('Y-m-d');
                //     $catAnteriores = Catalogo::where('estado', 'SIN PUBLICAR')->whereBetween('fecha_fin_catalogo', [$fechaFin, $fechaInicio])->get();
                //     foreach ($catAnteriores as $key => $catAnterior) {
                //         $catAntIds[] = $catAnterior->id;
                //     }
                // }
    
                // $pedidoActual = Venta::with('pedido')
                // ->where('id_empresaria', $empresaria->id)
                // ->whereHas('pedido', function ($query) use ($catIds) {
                //     $query->whereIn('id_catalogo', $catIds);
                // })->get();
                
                Empresaria::find($empresaria->id)->update(['tipo_cliente' => 'CONTINUA']);
                
            }
            if ($empresaria->tipo_cliente == 'PROSPECTO') {
                $emp = Empresaria::with('pedidos')->find($empresaria->id);
                $cant = $emp->pedidos->where('id_catalogo', $catalogo->id)->count();
                if ($cant <= 1) {
                    $emp->update(['tipo_cliente' => 'NUEVA']);
                }
            }
            if ($empresaria->tipo_cliente == 'INACTIVA-1' || $empresaria->tipo_cliente == 'INACTIVA-2' || $empresaria->tipo_cliente == 'INACTIVA-3' || $empresaria->tipo_cliente == 'POSIBLE BAJA') {
                $emp = Empresaria::with('pedidos')->find($empresaria->id);
                $cant = $emp->pedidos->where('id_catalogo', $catalogo->id)->count();
                if ($cant <= 1) {
                    $emp->update(['tipo_cliente' => 'REACTIVA']);
                }
            }
            if ($empresaria->tipo_cliente == 'REACTIVA') {
                $emp = Empresaria::with('pedidos')->find($empresaria->id);
                $cant = $emp->pedidos->where('id_catalogo', $catalogo->id)->count();
                if ($cant <= 1) {
                    $emp->update(['tipo_cliente' => 'CONTINUA']);
                }
            }
            if ($empresaria->tipo_cliente == 'BAJA') {
                $emp = Empresaria::with('pedidos')->find($empresaria->id);
                $cant = $emp->pedidos->where('id_catalogo', $catalogo->id)->count();
                if ($cant <= 1) {
                    $emp->update(['tipo_cliente' => 'RE-INGRESO']);
                }
            }
            if ($empresaria->tipo_cliente == 'RE-INGRESO') {
                $emp = Empresaria::with('pedidos')->find($empresaria->id);
                $cant = $emp->pedidos->where('id_catalogo', $catalogo->id)->count();
                if ($cant <= 1) {
                    $emp->update(['tipo_cliente' => 'CONTINUA']);
                }
            }
            if (empty($request->observaciones)) {
                $request->observaciones = 'SIN OBSERVACIONES';
            }

            return $response;
        } catch (\Throwable $th) {
            Venta::find($venta->id)->delete();
            return response()->json(['error' => 'No hay suficiente stock disponible.', 'producto' => $pro->descripcion, 'stock' => $pro->stock], 500);
        }
    }
    public function detalle_pedido($id_venta)
    {
        $pedidos = Pedido::where('id_venta', $id_venta)
            ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
            ->get();
        $i = 1;
        $venta = Venta::find($id_venta);
        return view('ecomerce.detalle-pedido', compact('pedidos', 'i', 'venta', 'id_venta'));
    }
    public function autocompletar_empresaria(Request $request)
    {
        $empresarias = Empresaria::where('cedula', 'LIKE', '%' . $request->term . '%')
            ->orWhere('nombres', 'LIKE', '%' . $request->term . '%')->get();
        $response = [];
        foreach ($empresarias as $empresaria) {
            array_push($response, ($empresaria->cedula . ' | ' . $empresaria->nombres));
        }
        return json_encode($response);
    }
    public function data_empresaria(Request $request)
    {
        $empresaria = Empresaria::where('cedula', $request->cedula)->orWhere('nombres', $request->nombres)
            ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'users.id', '=', 'empresarias.id_user')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'provincias.id as provincia_id', 'users.email as email')->first();
        $json = [];
        $json['empresaria'] = $empresaria;
        $catalogos = Catalogo::where('estado', 'PUBLICADO')->get();
        $condicion = [];
        $productoPremio = [];
        $flagPremioEmpresaria = 0;
        $flagPremioPedido = 0;
        $contPremio = 0;
        $contRegla = 0;

        $json['ciudad'] = DB::table('ciudades')->where('provincia_id', $empresaria->provincia_id)->where('estado', 'A')->get();

        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id', $catalogo->id)->get();
            // if (!empty($condicion)) {
            //     foreach ($condicion as  $value) {
            //         array_push($condiciones, $value);
            //     }
            // }
        }
        if (!empty($condicion)) {
            foreach ($condicion as $i => $value) {
                $reglas = json_decode($value->condicion);

                foreach ($reglas as $itemRegla) {
                    if ($itemRegla->nombre_tabla == 'empresarias') {
                        if (!$flagPremioEmpresaria) {
                            $valores = explode(' ', $itemRegla->condicion);
                            $estado = '"' . $valores[2] . '"';
                            //$premio = DB::table($itemRegla->nombre_tabla)->whereRaw("'".$valores[0]." ".$valores[1]." ".$estado."'")->get();
                            $premio = DB::table($itemRegla->nombre_tabla)->whereRaw($itemRegla->condicion)->get();
                            foreach ($premio as  $val) {
                                if ($val->id_user == $empresaria->id_user) {
                                    $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                                    foreach ($producto as  $value) {
                                        $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                        $colores2 = [];
                                        foreach ($colores as  $color) {
                                            array_push($colores2, $color->color);
                                        }
                                        $value->colores = $colores2;
                                        $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                        $tallas2 = [];
                                        foreach ($tallas as $talla) {
                                            array_push($tallas2, $talla->talla);
                                        }
                                        $value->tallas = $tallas2;
                                        array_push($productoPremio, $value);
                                    }
                                    //$json['premios'] = $productoPremio;
                                    $flagPremioEmpresaria = 1;
                                    $contPremio++;
                                }
                            }
                        }
                    }
                    if ($itemRegla->nombre_tabla == 'pedidos') {
                        $rule = $itemRegla->condicion;
                        $total_factura = Cart::total();
                        $rule  = str_replace('total_factura', $total_factura, $rule);

                        $valores = explode(' ', $rule);
                        $dbValor = str_replace("'", "", $valores[2]);
                        if ($valores[1] == '>') {
                            if ($total_factura > $dbValor) {
                                $flagPremioPedido = 1;
                            }
                        } elseif ($valores[1] == '>=') {
                            if ($total_factura >= $dbValor) {
                                $flagPremioPedido = 1;
                            }
                        }

                        if ($flagPremioPedido) {
                            $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                            foreach ($producto as  $value) {
                                $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                $colores2 = [];
                                foreach ($colores as  $color) {
                                    array_push($colores2, $color->color);
                                }
                                $value->colores = $colores2;
                                $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                $tallas2 = [];
                                foreach ($tallas as $talla) {
                                    array_push($tallas2, $talla->talla);
                                }
                                $value->tallas = $tallas2;
                                array_push($productoPremio, $value);
                            }
                            $contPremio++;
                        }
                        //pendiente validar por total de factura
                    }
                    $contRegla++;
                }
                if ($contPremio == $contRegla) {
                    $json['premios'] = $productoPremio;
                } else {
                    $productoPremio = [];
                }
                $contPremio = 0;
                $contRegla = 0;
                $flagPremioEmpresaria = 0;
                $flagPremioPedido = 0;
            }
        }
        return json_encode($json);
    }
    public function tracking_pedido($id_venta)
    {
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $venta = Venta::where('ventas.id', $id_venta)->join('users', 'users.id', '=', 'ventas.id_vendedor')->select('ventas.*', 'users.name')->first();
        return view('ecomerce.track-order', compact('venta'));
    }
    public function historial_compras()
    {
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
        $ventas = Venta::where('id_empresaria', $empresaria->id)->get();
        return view('ecomerce.historial-compra', compact('ventas', 'empresaria'));
    }
    public function perfil_empresaria()
    {
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'empresarias.vendedor', '=', 'users.id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'users.email as correo_vendedor', 'users.password as password_user', 'users.name as nombre_vendedor')
            ->first();
        return view('ecomerce.perfil-empresaria', compact('empresaria'));
    }
    public function detalle_compra_empresaria($id_venta)
    {
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $venta = Venta::where('id', $id_venta)->first();
        $empresaria = Empresaria::where('empresarias.id', $venta->id_empresaria)
            ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'empresarias.vendedor', '=', 'users.id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'users.email as correo_vendedor', 'users.name as nombre_vendedor')
            ->first();
        $pedidos = Pedido::where('id_venta', $venta->id)
            ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
            ->get();
        $i = 1;
        return view('ecomerce.factura-compra', compact('venta', 'empresaria', 'pedidos', 'i'));
    }
    public function seguimiento_pedidos()
    {
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
        $ventas = Venta::where('id_empresaria', $empresaria->id)->get();
        return view('ecomerce.seguimiento-pedidos', compact('ventas', 'empresaria'));
    }
    public function sobre_nosotros()
    {
        return view('ecomerce.sobre-nosotros');
    }
    public function premio_ventas()
    {
        $premios = Premio::join('catalogos', 'catalogos.id', '=', 'premios.catalogo_id')
            ->where('catalogos.estado', 'PUBLICADO')
            ->select('catalogos.nombre', 'catalogos.foto_path', 'catalogos.fecha_fin_catalogo', 'premios.descripcion', 'premios.id', 'catalogos.created_at')
            ->get();

        return view('ecomerce.premio-ventas', compact('premios'));
    }
    public function contacto()
    {
        return view('ecomerce.contactanos');
    }
    public function preguntasFrecuentes()
    {
        return view('ecomerce.preguntas-frecuentes');
    }
    public function terminosCondiciones()
    {
        return view('ecomerce.terminos-condiciones');
    }
    public function politicaPrivacidad()
    {
        return view('ecomerce.politica-privacidad');
    }
    public function registroEmpresaria()
    {
        $provincias = DB::table('provincias')->get();
        return view('ecomerce.registro-empresarias', compact('provincias'));
    }
    public function consultarCiudad()
    {
        $ciudades = DB::table('ciudades')
            ->where('provincia_id', '=', $_POST['id_provincia'])
            ->get();
        return json_encode($ciudades);
    }
    public function registrarEmpresariaNueva(Request $request)
    {
        $request->validate([
            'nombres' => 'required|max:255',
            'apellidos' => 'required',
            'cedula' => 'required|unique:empresarias,cedula',
            'email' => 'required|unique:users,email',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);
        $contrseña = Str::random(8);
        $userData = [
            'name' => trim(strtoupper($request->nombres)),
            'email' => trim($request->email),
            'password' => Hash::make($contrseña),
            'role' => 'Empresaria'
        ];
        $user = User::create($userData);
        $idRolEmpresaria = env('ID_ROL_EMPRESARIA', 14);
        $user->roles()->sync($idRolEmpresaria); // 14 es el id de el rol de empresaria 
        $empresariaData = [
            'cedula' => trim($request->cedula),
            'nombres' => trim(strtoupper($request->nombres)),
            'apellidos' => trim(strtoupper($request->apellidos)),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion' => trim(strtoupper($request->direccion)),
            'referencia' => trim(strtoupper($request->referencia)),
            'tipo_cliente' => 'PROSPECTO',
            'telefono' => trim($request->telefono),
            'id_ciudad' => $request->ciudad,
            'vendedor' => 0,
            'id_user' => $user->id
        ];
        Empresaria::create($empresariaData);
        $correo = new RegistroEmpresaria($request->all(), $contrseña);

        Mail::to($request->email)->send($correo);

        return view('ecomerce.registro-exitoso');
    }
    public function view_pedido()
    {
        if (Auth::user()->role == 'Administrador' || Auth::user()->role == 'ADMINISTRADOR') {
            return view('venta.pedido');
        }
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
        return view('pedidos.index', compact('empresaria'));
    }
    public function pedidos_guardados()
    {
        if (Auth::user()->role == 'Administrador') {
            return view('venta.pedidos-guardados');
        }
        if (Auth::user()->role != 'Empresaria') {
            return view('ecomerce.usuario-no-autorizado');
        }
        return view('pedidos.guardados');
    }

    public function email_contacto(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required|numeric',
            'comments' => 'required',
        ]);

        $input = $request->all();

        $correo = new Contacto($input);

        Mail::to('servicioalcliente.ibizza@zapecsa.com')->send($correo);

        // return view('ecomerce.contactanos')->with(['success' => 'Se envió el correo con éxito.']);

        return redirect()->back()->with(['success' => 'Se envió el correo con éxito.']);
    }
}
