<?php

use App\Empresaria;
use App\Http\Controllers\Admi\homeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\EmpresariaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\webController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//RUTAS PAGINA PRINCIPAL & FUNCIONES DE E-COMERCE

Route::get('/', webController::class)->name('web');
Route::get('/tienda', [webController::class,'tienda'])->name('web.tienda');
Route::get('/tienda/{category}/{orderBy}',[webController::class,'tiendaOrder'])->name('web.tiendaOrderBy');
Route::get('/carro-compras', [webController::class,'carrito'])->name('web.carro-compras');
Route::get('/detalle-producto/{estilo}', [webController::class,'detalle_producto'])->name('web.detalle-producto');
Route::post('tallas-x-color',[webController::class,'tallas_x_color'])->name('web.tallas-color');
Route::post('stock-x-talla',[webController::class,'stock_x_color'])->name('web.stock-talla');
Route::post('/store', [webController::class,'addToCart']);
Route::post('/delete', [webController::class,'deleteToCart']);
Route::get('checkout-ibizza',[webController::class,'checkout_view'])->name('web.checkout');
Route::get('/autocompletar', [webController::class,'autocompletar'])->name('web.autocompletar');
Route::get('/autocompletar-empresaria', [webController::class,'autocompletar_empresaria'])->name('web.autocompletar-empresaria');
Route::post('/data-empresaria', [webController::class,'data_empresaria'])->name('web.data-empresaria');
Route::post('chekout',[webController::class,'dataCheckout'])->name('web.checkout-productos');
Route::get('detalle-pedido-ibizza/{id_venta}',[webController::class,'detalle_pedido'])->name('web.detalle_pedido');
Route::get('tracking-ibizza/{id_venta}',[webController::class,'tracking_pedido'])->name('web.tracking-pedido');
Route::post('consulta-ciudad',[webController::class,'consultarCiudad'])->name('web.consutar-ciudad');
Route::post('registrar-empresaria-nueva',[webController::class,'registrarEmpresariaNueva'])->name('web.registrar-empresaria-nueva');
//RUTAS PAGINAS INFORMATIVAS
Route::get('/sobre-nosotros-ibizza', [webController::class,'sobre_nosotros'])->name('web.sobre-nosotros');
Route::get('/contactanos', [webController::class,'contacto'])->name('web.contactanos');
Route::get('/preguntas-frecuentes', [webController::class,'preguntasFrecuentes'])->name('web.preguntas-frecuentes');
Route::get('/termino-condiciones', [webController::class,'terminosCondiciones'])->name('web.terminos-condiciones');
Route::get('/politica-privacidad', [webController::class,'politicaPrivacidad'])->name('web.politica-privacidad');
Route::get('/registro-empresaria', [webController::class,'registroEmpresaria'])->name('web.registro-empresaria');

// RUTAS EMPRESARIAS LOGEADAS 
Route::get('historial-compras-empresaria',[webController::class,'historial_compras'])
->middleware(['auth:sanctum', 'verified'])->name('web.historial-compras');

Route::get('detalle-compras-empresaria/{id_venta}',[webController::class,'detalle_compra_empresaria'])
->middleware(['auth:sanctum', 'verified'])->name('web.detalle-compra-empresaria');

Route::get('perfil-empresaria',[webController::class,'perfil_empresaria'])
->middleware(['auth:sanctum', 'verified'])->name('web.perfil-empresaria');

Route::post('update-information-empresaria',[EmpresariaController::class,'update_perfil'])
->middleware(['auth:sanctum', 'verified'])->name('web.update-information-empresaria');

Route::get('seguimiento-pedidos',[webController::class,'seguimiento_pedidos'])
->middleware(['auth:sanctum', 'verified'])->name('web.seguimiento-pedidos');

// RUTAS DASHBOARD
Route::middleware(['can:dashboard','auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// PRODUCTO

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/upload', [ProductoController::class,'productoUpload'])
->name('producto.upload');

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/datatable', [ProductoController::class,'productoDataTable'])
->name('producto.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/estilos', [ProductoController::class,'productoEstilos'])
->name('producto.estilos');

Route::resource('productos', ProductoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/saveExcel/', [ProductoController::class,'saveExcel'])
->name('producto.saveExcel');

// MARCA

Route::resource('marcas', MarcaController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/marca/datatable', [MarcaController::class,'marcaDataTable'])
->name('marca.datatable');

// CATALOGO

Route::resource('catalogos', CatalogoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/datatable', [CatalogoController::class,'catalogoDataTable'])
->name('catalogo.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/catalogoProducto', [CatalogoController::class,'catalogoProducto'])
->name('catalogo.catalogoProducto');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/asignarProducto', [CatalogoController::class,'asignarProducto'])
->name('catalogo.asignarProducto');

// PREMIO

Route::resource('premios', PremioController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/premio/datatable', [PremioController::class,'premioDataTable'])
->name('premio.datatable');


// PROVEEDOR

Route::resource('proveedores', ProveedorController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/proveedor/datatable', [ProveedorController::class,'proveedorDataTable'])
->name('proveedor.datatable');

// REPORTE


Route::resource('reportes', ReporteController::class)
->middleware(['auth:sanctum', 'verified']);

// USUARIO

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/index/', [userController::class,'index'])
->name('usuario.index');

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/create/', [userController::class,'create'])
->name('usuario.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/create', [userController::class,'store'])
->name('new.user');

Route::middleware(['auth:sanctum', 'verified'])
->delete('/usuario/{id}', [userController::class,'destroy'])
->name('usuario.delete');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/datatable', [userController::class,'usuarioDataTable'])
->name('usuario.datatable');

// ROL

Route::resource('roles', RoleController::class)
->middleware(['auth:sanctum', 'verified'])
->names('admin.roles');

// EMPRESARIA

Route::resource('empresarias', EmpresariaController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/empresaria/ciudad', [EmpresariaController::class,'consultarCiudad'])
->name('empresaria.ciudad');

Route::middleware(['auth:sanctum', 'verified'])
->post('/empresaria/datatable', [EmpresariaController::class,'empresariaDatatable'])
->name('empresaria.datatable');

//ventas

Route::resource('ventas', VentaController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/ventas/datatable', [VentaController::class,'ventasDataTable'])
->name('venta.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->post('/ventas/datos-ventas', [VentaController::class,'datosVentas'])
->name('venta.datos-ventas');

Route::middleware(['auth:sanctum', 'verified'])
->post('/ventas/editar-venta', [VentaController::class,'editarVenta'])
->name('venta.datos-ventas');