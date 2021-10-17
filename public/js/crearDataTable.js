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
            "dataSrc": function(json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
                "data": 'id',
                "render": function(data, type, row) {
                    return '<a href="/productos/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
                }
            },
            {
                "data": "id"
            },
            {
                "data": "imagen_path",
                "render": function(data, type, row) {
                    let image = 'https://www.blackwallst.directory/images/NoImageAvailable.png';
                    if (data != '' && data != null) {
                        image = '/storage/images/productos/' + data
                    }
                    return '<center><img  src="'+image+'"class="rounded" width="80" height="60" /> </center>';
                }
            },
            {
                "data": "sku"
            },
            {
                "data": "nombre_producto"
            },
            {
                "data": "descripcion"
            },
            {
                "data": "nombre_marca"
            },
            {
                "data": "grupo"
            },
            {
                "data": "seccion"
            },
            {
                "data": "clasificacion"
            },
            {
                "data": "nombre_proveedor"
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
                "data": "stock"
            },
            {
                "data": "valor_venta"
            },
            {
                "data": "estado"
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
    $('#datatable tbody').on('click', '.eliminar', function() {
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
            "dataSrc": function(json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [
            {
                "data": "imagen_path",
                "render": function(data, type, row) {
                    let image = 'https://www.blackwallst.directory/images/NoImageAvailable.png';
                    if (data != '' && data != null) {
                        image = '/storage/images/productos/' + data
                    }
                    return '<center><img  src="'+image+'"class="rounded" width="80" height="60" /> </center>';
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
                "defaultContent":  btnEditar + btnEliminar
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
    $('#datatable tbody').on('click', '.eliminar', function() {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#texto').html('EDITAR LA IMAGEN DEL ESTILO '+data.estilo+' Y EL COLOR '+data.color);
        $('#estilo').val(data.estilo);
        $('#color').val(data.color);
        $('#imagen_path').val(data.imagen_path);

    })
    $('#datatable tbody').on('click', '.editar', function() {
        let image = 'https://www.blackwallst.directory/images/NoImageAvailable.png';
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#texto').html('EDITAR LA IMAGEN DEL ESTILO '+data.estilo+' Y EL COLOR '+data.color);
        $('#estilo').val(data.estilo);
        $('#color').val(data.color);
        $('#imagen_path').val(data.imagen_path);
        if(data.imagen_path != null){
            $('#imagen_defecto').attr('src','/storage/images/productos/'+data.imagen_path);
        }else{
             $('#imagen_defecto').attr('src',image);
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
            "dataSrc": function(json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
                "data": 'id',
                "render": function(data, type, row) {
                    return '<a href="/marcas/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
                }
            },
            {
                "data": "nombre"
            },
            {
                "data": "imagen",
                "render": function(data, type, row) {
                    let image = 'https://www.blackwallst.directory/images/NoImageAvailable.png';
                    if (data != '' && data != null) {
                        image = '/storage/images/marca/' + data
                    }
                    return '<img src="' + image + '" width="50px" class="rounded img-fluid" style="height: 50px; object-fit: cover">';
                }
            },
            {
                "data": "estado"
            }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false
            },
            { "width": "1%", "targets": 0 }
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
    $('#datatable tbody').on('click', '.eliminar', function() {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/marcas/" + data.id);
    })
}

function crearTablaProveedor(data, ruta) {
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
            "dataSrc": function(json) {
                if (json == 'no data') {
                    return [];
                } else {
                    return json;
                }
            },
        },
        "columns": [{
                "data": 'id',
                "render": function(data, type, row) {
                    return '<a href="/proveedores/' + data + '/edit" class ="btn btn-ibizza btn-sm" style="width:30px"> <i class="fas fa-edit"></i></a>' + btnEliminar;
                }
            },
            {
                "data": "nombre"
            },
            {
                "data": "estado"
            }

        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todo"]
        ],
        "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "searchable": false
            },
            { "width": "1%", "targets": 0 }
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
    $('#datatable tbody').on('click', '.eliminar', function() {
        let data = $('#datatable').DataTable().row($(this).parents()).data();
        $('#elemento_eliminar').html(data.nombre);
        $('#id_eliminar').val(data.id)
        $('#form_eliminar').attr('action', "/proveedores/" + data.id);
    })
}