let espanol = {
    "sProcessing": '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>',
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    },
    "buttons": {
        "copy": "Copiar",
        "colvis": "Visibilidad"
    }
}

function crearTabla(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/productos/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        },
        {
            "data": "id"
        },
        {
            "data": "imagen_path",
            "render": function (data, type, row) {
                let image = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
                if (data != '' && data != null) {
                    image = '/storage/images/productos/' + data
                }
                return '<center><img  src="' + image + '"class="rounded" width="60" height="60" /> </center>';
            }
        },
        {
            "data": "sku"
        },
        {
            "data": "descripcion"
        },
        {
            "data": "nombre_marca"
        },
        {
            "data": "clasificacion"
        },
        {
            "data": "categoria"
        },
        {
            "data": "subcategoria"
        },
        {
            "data": "estilo"
        },
        {
            "data": "color"
        },
        {
            "data": "talla"
        },
        {
            "data": "cantidad_inicial"
        },
        {
            "data": "stock",
            "render": function (data, type, row) {
                let color = 'bg-success'
                if (data < 10) { color = 'bg-danger' }
                if (data == 0) { color = 'bg-danger'; data = 'AGOTADO' }
                return '<span class="badge ' + color + ' w-100 p-2">' + data + '</span>';
            }
        },
        {
            "data": "nombre_catalogo"
        },
        {
            "data": "precio_empresaria"
        },
        {
            "data": "estado"
        },
        {
            "data": "observaciones",
        }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre_producto);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/productos/" + data.id);
    })
}

function crearTablaEstilos(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger"type ="button" data-toggle = "modal" data-target = "#eliminar"> <i class="fas fa-trash"></i></button>';
    let btnEditar = '<a class ="editar btn btn-ibizza me-2" data-toggle = "modal" data-target = "#editar"> <i class="fas fa-edit"></i></a>'
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "imagen_path",
            "render": function (data, type, row) {
                let image = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
                if (data != '' && data != null) {
                    image = '/storage/images/productos/' + data
                }
                return '<center><img  src="' + image + '"class="rounded" width="80" height="60" /> </center>';
            }
        },
        {
            "data": "estilo"
        },
        {
            "data": "color"
        },
        {
            "data": 'id',
            "defaultContent": btnEditar + btnEliminar
        },

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#texto2').html('SEGURO DE ELIMINAR LA IMAGEN DEL ESTILO ' + data.estilo + ' Y EL COLOR ' + data.color);
        $('#estilo2').val(data.estilo);
        $('#color2').val(data.color);
        $('#imagen_path2').val(data.imagen_path);

    })
    $('#datatable tbody').on('click', '.editar', function () {
        let image = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#texto').html('EDITAR LA IMAGEN DEL ESTILO ' + data.estilo + ' Y EL COLOR ' + data.color);
        $('#estilo').val(data.estilo);
        $('#color').val(data.color);
        $('#imagen_path').val(data.imagen_path);
        if (data.imagen_path != null) {
            $('#imagen_defecto').attr('src', '/storage/images/productos/' + data.imagen_path);
        } else {
            $('#imagen_defecto').attr('src', image);
        }
    })
}

function crearTablaMarca(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "imagen",
            "render": function (data, type, row) {
                let image = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
                if (data != '' && data != null) {
                    image = '/storage/images/marca/' + data
                }
                return '<img src="' + image + '" class="rounded" width="80" height="60" >';
            }
        },
        {
            "data": "nombre"
        },

        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-danger">Inactivo</span>';
                if (data == 'A') {
                    estado = '<span class="badge bg-success">Activo</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/marcas/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [3],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/marcas/" + data.id);
    })
}

function crearTablaUsuario(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:30px"> <i class="fas fa-trash"></i></button>';

    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "identificacion"
        },
        {
            "data": "name"
        },
        {
            "data": "email"
        },

        {
            "data": "role"
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/usuario/edit/'+data+'" class ="editar btn btn-ibizza me-2 btn-sm"> <i class="fas fa-edit"></i></a>'+btnEliminar;
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [3],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/usuario/" + data.id);
    })
}

function crearTablaCatalogo(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [
        {
            "data": "id"
        },
        {
            "data": "foto_path",
            "render": function (data, type, row) {
                let image = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
                if (data != '' && data != null) {
                    image = '/storage/images/catalogo/' + data
                }
                return '<img src="' + image + '" class="rounded" width="80" height="60" >';
            }
        },
        {
            "data": "nombre"
        },
        {
            "data": "descripcion"
        },
        {
            "data": "fecha_publicacion"
        },
        {
            "data": "fecha_fin_catalogo"
        },
        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-secondary">Sin publicar</span>';
                if (data == 'PUBLICADO') {
                    estado = '<span class="badge bg-success">Publicado</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/catalogos/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [6],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/catalogos/" + data.id);
    })
}

function crearTablaPCatalogo(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar_regla" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [
        {
            "data": "id"
        },
        {
            "data": "catalogo.nombre"
        },
        {
            "data": "tipo_empresaria"
        },
        {
            "data": "condicion"
        },
        {
            "data": "operador"
        },
        {
            "data": "cantidad"
        },
        {
            "data": "valor"
        },
        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-secondary">Inactivo</span>';
                if (data == 1) {
                    estado = '<span class="badge bg-success">Activo</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/regla/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        },
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [6],
            "orderable": false,
            "searchable": false
        },
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }

    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.id);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/parametros/" + data.id);
    })
}


function crearTablaPMarcas(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar_regla" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [
        {
            "data": "id"
        },
        {
            "data": "nombre"
        },
        {
            "data": "tipo_empresaria"
        },
        {
            "data": "condicion"
        },
        {
            "data": "operador"
        },
        {
            "data": "cantidad"
        },
        {
            "data": "descuento"
        },

        {
            "data": "categorías",
            // "render": function (data, type, row) {
            //     let marcas = '';
            //     data.forEach(element => {
            //         marcas += '<span class="badge bg-warning mr-1">'+ element +'</span>';
            //     });
            //     return marcas;
            // }
        },
        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-secondary">Inactivo</span>';
                if (data == 1) {
                    estado = '<span class="badge bg-success">Activo</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/parametro-marca/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        },
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [6],
            "orderable": false,
            "searchable": false
        },
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }

    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.id);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/parametro-marca/" + data.id);
    })
}

function crearTablaReservas(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar_regla" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({
        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [
        {
            "data": "id"
        },
        {
            "data": "nombre_cliente"
        },
        {
            "data": "empresaria.tipo_cliente"
        },
        {
            "data": "cantidad_total"
        },
        {
            "data": "total_venta"
        },
        {
            "data": "usuario.name"
        },
        {
            "data": "created_at",
            "render": function (data, type, row) {
                return moment(data).format('DD/MM/YYYY');
            }
        },
        {
            "data": "created_at",
            "render": function (data, type, row) {
                var fecha = moment(data).add(3, 'days');
                return fecha.format('DD/MM/YYYY');
            }
        }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [6],
            "orderable": false,
            "searchable": false
        },
        ],
        "order": [
            [1, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
}

function crearTablaPremio(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:30px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "descripcion"
        },

        {
            "data": "nombre"
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/premios/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [2],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [0, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.descripcion);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/premios/" + data.id);
    })
}

function crearTablaProveedor(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar" style="width:50px"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "nombre"
        },
        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-danger">Inactivo</span>';
                if (data == 'A' || data == 'ACTIVO' || data == 'a') {
                    estado = '<span class="badge bg-success">Activo</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/proveedores/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:50px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        }
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [2],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [0, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/proveedores/" + data.id);
    })
}

function crearTablaEmpresarias(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let btnEliminar = '<button class ="eliminar btn btn-danger btn-sm"type ="button" data-toggle = "modal" data-target = "#eliminar"> <i class="fas fa-trash"></i></button>';
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "cedula"
        },
        {
            "data": "nombres",
            'render': function (data, type, row) {
                return data + " " + row['apellidos'];
            }
        },
        {
            "data": "fecha_nacimiento"
        },
        {
            "data": "telefono"
        },
        {
            "data": "nombre_ciudad"
        },
        {
            "data": "tipo_cliente",
            "render": function (data, type, row) {
                let color = 'bg-success'
                if (data == 'CONTINUA') { color = 'bg-info' }
                if (data == 'BAJA') { color = 'bg-danger' }
                if (data == 'INACTIVA-1' || data == 'INACTIVA-2' || data == 'INACTIVA-3') { color = 'bg-warning text-dark' }
                return '<span class="badge ' + color + ' w-100 p-2">' + data + '</span>';
            }
        },
        {
            "data": "nombre_vendedor"
        },
        {
            "data": "created_at",
            "render": function (data, type, row) {
                data = data.split(' ');
                return data[0];
            }
        },
        {
            "data": "estado",
            "render": function (data, type, row) {
                let estado = '<span class="badge bg-danger">Inactivo</span>';
                if (data == 'A') {
                    estado = '<span class="badge bg-success">Activo</span>'
                }
                return estado;
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {
                return '<a href="/empresarias/' + data + '/edit" class ="btn btn-ibizza me-1 btn-sm"> <i class="fas fa-edit"></i></a>' + btnEliminar;
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [8],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [0, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.eliminar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombres);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/empresarias/" + data.id);
    })
}

function crearTablaVentas(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let dataTable = $('#datatable').DataTable({

        destroy: true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "id",
        },
        {
            "data": "factura_identificacion",
        },
        {
            "data": "factura_nombres"
        },

        {
            "data": "direccion_envio"
        },
        {
            "data": 'empresaria'
        },
        {
            "data": 'observaciones'
        },
        {
            "data": 'cantidad_total'
        },
        {
            "data": 'total_venta'
        },
        {
            "data": 'estado'
        },
        {
            "data": 'created_at',
            "render": function (data, type, row) {
                data = data.split('T');
                return data[0];
            }
        },
        {
            "data": 'id',
            "render": function (data, type, row) {

                return '<a class ="btn btn-ibizza btn-sm editar" data-bs-toggle="modal" data-bs-target="#editar" style="width:30px"><i class="fas fa-eye"></i></a>&nbsp;<a class ="btn btn-warning btn-sm pedido" data-bs-toggle="modal" data-bs-target="#pedido" style="width:30px"><i class="fas fa-file-invoice-dollar"></i></a>'
            }
        }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
            "targets": [3, 10],
            "orderable": false,
            "searchable": false
        },
            //{ "width": "1%", "targets": 0 }
        ],
        "order": [
            [0, 'desc']
        ],
        "language": espanol,
        //para usar los botones
        responsive: false,
        autoWidth: false,
        dom: 'Bfrtilp',
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
    $('#datatable tbody').on('click', '.editar', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#id_venta').text(data.id);
        let dato = {
            id_venta: data.id,
        }
        $.post({
            url: '/ventas/datos-ventas',
            data: dato,
            beforeSend: function () {
                $('#carga').css('visibility', 'visible');
            },
            success: function (response) {
                $('#carga').css('visibility', 'hidden')
                let data = JSON.parse(response);
                let empresaria = data['empresaria'];
                let venta = data['venta'];
                let rol = data['rol'];
                let direccionVenta = data['direccionVenta'];
                if(rol == "ASESOR"){
                    $('#estado_venta').prop( "disabled", true );
                }else{
                    $('#estado_venta').prop( "disabled", false );
                }
                Livewire.emitTo('guardar-pago', 'setVenta', venta['id']);
                $('#estado_venta').val(venta['estado']);
                $('#venta').text(venta['id'])
                $('#nfactura').text(venta['n_factura'])
                $('#nguia').text(venta['n_guia'])
                $('#btn-descarga').attr( 'href','/venta/comprobante/' + venta['id']);
                $('#fcedula').text(venta['factura_identificacion'])
                $('#fnombre').text(venta['factura_nombres'])
                $('#ftelefono').text(venta['telefono'])
                $('#femail').text(venta['email'])
                $('#empresaria').text(empresaria['nombres'] + ' ' + empresaria['apellidos'])
                $('#cedula').text(empresaria['cedula'])
                $('#telefono').text(empresaria['telefono'])
                $('#correo').text(empresaria['usuario']['email'])
                $('#enombre').text(direccionVenta['nombre'])
                $('#etelefono').text(direccionVenta['telefono'])
                $('#eprovincia').text(direccionVenta['ciudad']['provincia']['descripcion'])
                $('#eciudad').text(direccionVenta['ciudad']['descripcion'])
                $('#direccion').text(direccionVenta['direccion'])
                $('#referencia').text(direccionVenta['referencia'])
                $('#imagen_path').val(venta['recibo']);
                if (venta['recibo'] != null) {
                    $('#imagen_defecto').attr('src',venta['recibo']);
                }
                $('#vendedor').text(venta['vendedor']['name'])
                let fecha = venta['created_at'];
                fecha = fecha.split('T');
                $('#fecha').text(fecha[0]);
                data = data['pedidos'];
                $('#tabla_factura tbody').html('');
                let subtotal = 0
                let total_factura = 0
                let cantidad_total = 0
                let envio = venta['envio'];
                let ganancia = 0
                $.each(data, function (i, v) {
                    let image = '/img/imagen-no-disponible.jpg';
                    if(v['imagen_producto'] != null && v['imagen_producto'] != ''){
                        image = '/storage/images/productos/' + v['imagen_producto'];
                    }
                    let total = v['precio'] ;
                    let direccion = v['direccion_envio'] != '' ? JSON.parse(v['direccion_envio']) : '';
                    total = total.toFixed(2);
                    if(direccion != ''){
                        $('#tabla_factura tbody').append('<tr>' +
                            '<td><img src="' + image + '" width="50px"></td>' +
                            '<td>' + v['nombre_producto'] + '</td>' +
                            '<td>' + v['color_producto'] + '</td>' +
                            '<td>' + v['talla_producto'] + '</td>' +
                            '<td>' + v['precio_catalogo'] + '</td>' +
                            '<td>'+ v['descuento'] +'</td>' +
                            '<td>' + v['cantidad'] + '</td>' +
                            '<td>$' + total + '</td>' +
                            '<td>Nombre:'+ direccion.nombre+' <br>Tel:'+ direccion.telefono+
                            '<br> Dir:'+ direccion.direccion +'<br> Ref:'+ direccion.referencia +
                            '</tr>')
                    }else{
                        $('#tabla_factura tbody').append('<tr>' +
                            '<td><img src="' + image + '" width="50px"></td>' +
                            '<td>' + v['nombre_producto'] + '</td>' +
                            '<td>' + v['color_producto'] + '</td>' +
                            '<td>' + v['talla_producto'] + '</td>' +
                            '<td>' + v['precio_catalogo'] + '</td>' +
                            '<td>'+ v['descuento'] +'</td>' +
                            '<td>' + v['cantidad'] + '</td>' +
                            '<td>$' + total + '</td>' +
                            '<td></td>')
                    }
                    subtotal = parseFloat(subtotal) + parseFloat(v['precio_catalogo']);
                    total_factura = parseFloat(total) + parseFloat(total_factura);
                    cantidad_total = parseInt(v['cantidad']) + parseInt(cantidad_total);
                })
                total_factura = total_factura.toFixed(2)

                $('#subtotal').text(subtotal.toFixed(2));
                $('#cant_total').text(cantidad_total);
                $('#total_fac').text(total_factura);
                $('#envio').text(envio);
                totpag = parseFloat(total_factura) + parseFloat(envio);
                $('#tot_pagar').text(totpag.toFixed(2));
                $('#ganancia').text(venta['total_p_empresaria']);


            }
        })
    })

    $('#datatable tbody').on('click', '.pedido', function () {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#id_venta_t').text(data.id);
        let dato = {
            id_venta: data.id,
        }
        $.post({
            url: '/ventas/datos-pedido',
            data: dato,
            beforeSend: function () {
                $('#cargat').css('visibility', 'visible');
            },
            success: function (response) {
                $('#cargat').css('visibility', 'hidden')
                let data = JSON.parse(response);
                let empresaria = data['empresaria'];
                let venta = data['venta'];
                $('#venta_t').text(venta['id'])
                $('#vendedor_t').text(venta['vendedor']['name'])
                let fecha = venta['created_at'];
                fecha = fecha.split('T');
                $('#fecha_t').text(fecha[0]);

                if(venta['estado'] == "PENDIENTE DE PAGO"){
                    $("#pendiente").addClass("bg-green");
                    $("#tomar_pedido").removeClass("bg-green");
                    $("#verificar_pago").removeClass("bg-green");
                    $("#facturado").removeClass("bg-green");
                    $("#despachado").removeClass("bg-green");
                }
                if(venta['estado'] == "PEDIDO POR VALIDAR"){
                    $("#pendiente").removeClass("bg-green");
                    $("#tomar_pedido").removeClass("bg-green");
                    $("#verificar_pago").addClass("bg-green");
                    $("#facturado").removeClass("bg-green");
                    $("#despachado").removeClass("bg-green");
                }
                if(venta['estado'] == "PEDIDO APROBADO"){
                    $("#pendiente").removeClass("bg-green");
                    $("#tomar_pedido").addClass("bg-green");
                    $("#verificar_pago").removeClass("bg-green");
                    $("#facturado").removeClass("bg-green");
                    $("#despachado").removeClass("bg-green");
                }
                if(venta['estado'] == "PEDIDO FACTURADO"){
                    $("#pendiente").removeClass("bg-green");
                    $("#tomar_pedido").removeClass("bg-green");
                    $("#verificar_pago").removeClass("bg-green");
                    $("#facturado").addClass("bg-green");
                    $("#despachado").removeClass("bg-green");
                }
                if(venta['estado'] == "PEDIDO DESPACHADO"){
                    $("#pendiente").removeClass("bg-green");
                    $("#tomar_pedido").removeClass("bg-green");
                    $("#verificar_pago").removeClass("bg-green");
                    $("#facturado").removeClass("bg-green");
                    $("#despachado").addClass("bg-green");
                }

            }
        })
    })
}

function reporteEmpresariaVentas(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let dataTable = $('#datatable_venta').DataTable({

        "destroy": true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "cedula"
        },
        {
            "data": "nombres"
        },

        {
            "data": "total",
        },


        ],
        "lengthMenu": [
            [-1, 10, 25, 50],
            ["Todo", 10, 25, 50]
        ],
        "order": [
            [0, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        "responsive": false,
        "autoWidth": false,
        "dom": 'Bfrtilp',
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
}

function reporteEmpresariaEstado(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let dataTable = $('#datatable_estado').DataTable({

        "destroy": true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
            "data": "cedula"
        },
        {
            "data": "nombres"
        },

        {
            "data": "tipo_cliente",
        },
        ],
        "lengthMenu": [
            [-1, 10, 25, 50],
            ["Todo", 10, 25, 50]
        ],
        "order": [
            [0, 'asc']
        ],
        "language": espanol,
        //para usar los botones
        "responsive": false,
        "autoWidth": false,
        "dom": 'Bfrtilp',
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
}

function stockFaltante(data, ruta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
    let dataTable = $('#datatable').DataTable({

        "destroy": true,
        "processing": true,
        "ajax": {
            "url": ruta,
            "method": "POST",
            "data": data,
            "dataSrc": function (json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
                "data": "nombre_mostrar"
            },
            {
                "data": "nombre"
            },
            {
                "data": "estilo"
            },
            {
                "data": "color"
            },
            {
                "data": "talla",
            },
            {
                "data": "stock_requerido",
            },
            {
                "data": "fecha",
            },
        ],
        "lengthMenu": [
            [-1, 10, 25, 50],
            ["Todo", 10, 25, 50]
        ],
        "order": [
            [5, 'desc']
        ],
        "language": espanol,
        //para usar los botones
        "responsive": false,
        "autoWidth": false,
        "dom": 'Bfrtilp',
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
    if (dataTable.length == 0) {
        dataTable.clear();
        dataTable.draw();
    }
}

function reporteVentas() {
    let dataTable = $('#datatable').DataTable({
        "processing": true,
        "lengthMenu": [
            [-1, 10, 25, 50],
            ["Todo", 10, 25, 50]
        ],
        "order": [
            [4, 'desc']
        ],
        "language": espanol,
        //para usar los botones
        "responsive": false,
        "autoWidth": false,
        "dom": 'Bfrtilp',
        "buttons": [{
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i> ',
            titleAttr: 'Exportar a Excel',
            className: 'btn btn-success',
        },
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> ',
            titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            pageSize: 'TABLOID',
            orientation: 'landscape'
        },
        {
            extend: 'print',
            text: '<i class="fa fa-print"></i> ',
            titleAttr: 'Imprimir',
            className: 'btn btn-info',
            exportOptions: {
                stripHtml: false
            }
        },
        ]
    });
}

