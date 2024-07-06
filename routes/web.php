<?php

use App\Empresaria;
use App\Http\Controllers\Admi\homeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CambiosPedidosController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\EmpresariaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReservarCambiosPedidosController;
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
// Route::get('/tienda/{category}/{orderBy}',[webController::class,'tiendaOrder'])->name('web.tiendaOrderBy');
// Route::get('/carro-compras', [webController::class,'carrito'])->name('web.carro-compras');
// Route::get('/detalle-producto/{estilo}', [webController::class,'detalle_producto'])->name('web.detalle-producto');
// Route::post('tallas-x-color',[webController::class,'tallas_x_color'])->name('web.tallas-color');
// Route::post('stock-x-talla',[webController::class,'stock_x_color'])->name('web.stock-talla');
// Route::post('/store', [webController::class,'addToCart']);
Route::post('/delete', [webController::class,'deleteToCart']);
Route::get('checkout-ibizza',[webController::class,'checkout_view'])->name('web.checkout');
Route::get('/autocompletar', [webController::class,'autocompletar'])->name('web.autocompletar');
Route::get('/autocompletar-empresaria', [webController::class,'autocompletar_empresaria'])->name('web.autocompletar-empresaria');
Route::post('/data-empresaria', [webController::class,'data_empresaria'])->name('web.data-empresaria');
Route::post('chekout',[webController::class,'dataCheckout'])->name('web.checkout-productos');
Route::get('detalle-pedido-ibizza/{id_venta}',[webController::class,'detalle_pedido'])
->middleware(['auth:sanctum', 'verified'])->name('web.detalle_pedido');
Route::get('tracking-ibizza/{id_venta}',[webController::class,'tracking_pedido'])
->middleware(['auth:sanctum', 'verified'])->name('web.tracking-pedido');
Route::post('consulta-ciudad',[webController::class,'consultarCiudad'])->name('web.consutar-ciudad');
Route::post('registrar-empresaria-nueva',[webController::class,'registrarEmpresariaNueva'])->name('web.registrar-empresaria-nueva');
// NUEVO FORMA TOMAR PEDIDO
Route::get('pedido-ibizza',[webController::class,'view_pedido'])
->middleware(['auth:sanctum', 'verified'])->name('web.tomar-pedido');

Route::get('pedido-ibizza-reservados',[webController::class,'pedidos_guardados'])
->middleware(['auth:sanctum', 'verified'])->name('web.pedidos-guardados');
//RUTAS PAGINAS INFORMATIVAS
Route::get('/sobre-nosotros-ibizza', [webController::class,'sobre_nosotros'])->name('web.sobre-nosotros');
Route::get('/premio-ventas', [webController::class,'premio_ventas'])->name('web.premio-ventas');
Route::get('/contactanos', [webController::class,'contacto'])->name('web.contactanos');
Route::post('/email-contacto',[webController::class,'email_contacto'])->name('web.email-contacto');
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
Route::get('dashboard',[userController::class,'dashboard'])
->middleware(['auth:sanctum', 'verified'])
->name('dashboard');

// PRODUCTO

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/upload', [ProductoController::class,'productoUpload'])
->name('producto.upload');

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/datatable', [ProductoController::class,'productoDataTable'])
->name('producto.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/datatableStock', [ProductoController::class,'productoDataTableStock'])
->name('producto.datatable-stock');

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/estilos', [ProductoController::class,'productoEstilos'])
->name('producto.estilos');

Route::resource('productos', ProductoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/saveExcel/', [ProductoController::class,'saveExcel'])
->name('producto.saveExcel');

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/stock-faltante', [ProductoController::class,'stockFaltante'])
->name('producto.stock-faltante');

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

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/parametros-marca', [CatalogoController::class,'parametrosMarca'])
->name('catalogo.parametros-marca');


Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/parametros-marca-new', [CatalogoController::class,'parametrosMarcaNew'])
->name('catalogo.parametros-marca-nuevo');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/parametros-marca-new', [CatalogoController::class,'parametrosMarcaNewStore'])
->name('catalogo.parametros-marca-nuevo.store');

Route::middleware(['auth:sanctum', 'verified'])
->get('/parametro-marca/{id}/edit', [CatalogoController::class,'parametrosMarcaEdit'])
->name('parametro-marca.edit');

Route::middleware(['auth:sanctum', 'verified'])
->post('/parametro-marca/edit/{id}', [CatalogoController::class,'parametrosMarcaUpdate'])
->name('catalogo.parametros-marca.update');

Route::middleware(['auth:sanctum', 'verified'])
->delete('/parametro-marca/{id}', [CatalogoController::class,'parametrosMarcaDelete'])
->name('catalogo.parametros-marca.delete');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/parametros-marca/listar', [CatalogoController::class,'parametrosMarcaListar'])
->name('catalogo.parametros-marca.index');

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/parametros', [CatalogoController::class,'parametros'])
->name('catalogo.parametros');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/parametros/listar', [CatalogoController::class,'parametros_listar'])
->name('catalogo.parametros.index');

Route::middleware(['auth:sanctum', 'verified'])
->get('/regla/{id}/edit', [CatalogoController::class,'regla_edit'])
->name('parametros.edit');

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/reglas', [CatalogoController::class,'reglas'])
->name('catalogo.reglas');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/reglas/create', [CatalogoController::class,'reglasCreate'])
->name('catalogo.reglas.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('reglas/edit/{id}', [CatalogoController::class,'reglasUpdate'])
->name('catalogo.reglas.edit');

Route::middleware(['auth:sanctum', 'verified'])
->delete('parametros/{id}', [CatalogoController::class,'reglasDelete'])
->name('catalogo.reglas.delete');

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/ofertas', [CatalogoController::class,'ofertas'])
->name('ofertas.index');

Route::middleware(['auth:sanctum', 'verified'])
->get('/ofertas/create', [CatalogoController::class,'ofertasCreate'])
->name('ofertas.create');

Route::middleware(['auth:sanctum', 'verified'])
->get('/oferta/{id}/edit', [CatalogoController::class,'ofertasEdit'])
->name('ofertas.edit');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/ofertas/listar', [CatalogoController::class,'ofertasListar'])
->name('ofertas.listar');

Route::middleware(['auth:sanctum', 'verified'])
->delete('/catalogo/oferta/{id}', [CatalogoController::class,'ofertasDelete'])
->name('ofertas.delete');

// PREMIO

Route::resource('premios', PremioController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/premio/datatable', [PremioController::class,'premioDataTable'])
->name('premio.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->post('/premio/delete-condicion', [PremioController::class, 'deleteCondicion'])
->name('premio.delete-condicion');


// PROVEEDOR

Route::resource('proveedores', ProveedorController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/proveedor/datatable', [ProveedorController::class,'proveedorDataTable'])
->name('proveedor.datatable');

// REPORTE
Route::resource('reportes', ReporteController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/reporte/empresariaReports', [ReporteController::class,'empresariaReports'])
->name('reporte.empresariaReports');

Route::middleware(['auth:sanctum', 'verified'])
->get('/reporte/graficos', [ReporteController::class,'graficos'])
->name('reporte.graficos');

Route::middleware(['auth:sanctum', 'verified'])
->get('/reporte/ventas', [ReporteController::class,'ventas'])
->name('reporte.ventas');

// USUARIO

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/index/', [userController::class,'index'])
->name('usuario.index');


Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/edit/{id}', [userController::class,'edit'])
->name('usuario.edit');

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/create/', [userController::class,'create'])
->name('usuario.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/create', [userController::class,'store'])
->name('new.user');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/editar/{id}', [userController::class,'update'])
->name('edit.user');

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


//Reservar Cambios
Route::resource('cambios', CambiosPedidosController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/cambio/datatable', [CambiosPedidosController::class,'cambiosDataTable'])
->name('cambio.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->post('/cambio/datos-cambio', [CambiosPedidosController::class,'datosCambios'])
->name('cambio.datos-cambio');

Route::middleware(['auth:sanctum', 'verified'])
->post('/cambio/editar-cambio', [CambiosPedidosController::class,'editarCambio'])
->name('cambio.datos-cambio-editar');

Route::middleware(['auth:sanctum', 'verified'])
->post('/cambio/eliminar-cambio', [CambiosPedidosController::class,'deleteChangeOrder'])
->name('cambio.datos-cambio-eliminar');

Route::middleware(['auth:sanctum', 'verified'])
->get('/cambio/comprobante/{id}', [CambiosPedidosController::class,'generarComprobante'])
->name('cambio.comprobante');



Route::middleware(['auth:sanctum', 'verified'])
->get('/cambio/pdf-reservado/{id}', [ReservarCambiosPedidosController::class,'generatePdfChangeReserved'])
->name('cambio.pdf-reservado');




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
->post('/ventas/datos-pedido', [VentaController::class,'datosPedido'])
->name('venta.datos-pedido');

Route::middleware(['auth:sanctum', 'verified'])
->post('/ventas/carga-recibo', [VentaController::class,'cargaRecibo'])
->name('venta.carga-recibo');

Route::middleware(['auth:sanctum', 'verified'])
->post('/ventas/editar-venta', [VentaController::class,'editarVenta'])
->name('venta.datos-ventas');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/upload', [VentaController::class,'ventasUpload'])
->name('venta.upload');

Route::middleware(['auth:sanctum', 'verified'])
->get('/cambio/upload', [VentaController::class,'cambioUpload'])
->name('cambio.upload');

Route::middleware(['auth:sanctum', 'verified'])
->post('/venta/saveExcel', [VentaController::class,'saveExcel'])
->name('venta.saveExcel');

Route::middleware(['auth:sanctum', 'verified'])
->post('/venta/saveExcelCambio', [VentaController::class,'saveExcelCambio'])
->name('venta.saveExcelCambio');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/pedido/{empresaria?}/{envio?}', [VentaController::class,'tomar_pedido'])
->name('venta.pedido');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/pedidos-guardados', [VentaController::class,'pedidos_guardados'])
->name('venta.pedidos-guardados');



Route::middleware(['auth:sanctum', 'verified'])
->get('/cambio/cambios-reservados', [ReservarCambiosPedidosController::class,'cambios_pedidos_guardados'])
->name('cambio.cambios-reservados');

Route::middleware(['auth:sanctum', 'verified'])
->get('/cambio/cambios-reservados/{id}', [VentaController::class,'view_cambios_reservado'])
->name('venta.cambios-reservados');



Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/pedidos-reservados', [VentaController::class,'pedidos_reservados'])
->name('venta.pedidos-reservados');

Route::middleware(['auth:sanctum', 'verified'])
->post('/venta/datatable/reservas', [VentaController::class,'datatable_reservas'])
->name('venta.tabla-reservas');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/comprobante/{id}', [VentaController::class,'generarComprobante'])
->name('venta.comprobante');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/pdf-pedido/{id}', [VentaController::class,'generarPedidoGuardado'])
->name('venta.pdf-pedido');

Route::middleware(['auth:sanctum', 'verified'])
->get('/venta/cambios', [VentaController::class,'view_cambios'])
->name('venta.cambios');


