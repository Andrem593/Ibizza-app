<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => '',
    'title_postfix' => '| Ibizza',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '',
    'logo_img' => 'vendor/adminlte/dist/img/Logo_ibizza.svg',
    'logo_img_class' => 'logo_ibizza',
    'logo_img_xl' => null,
    'logo_img_xl_class' => '',
    'logo_img_alt' => 'Ibizza-app',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-dark elevation-2',
    'classes_sidebar_nav' => 'nav-flat',
    'classes_topnav' => 'navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'Buscar',
            'topnav_right' => false,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => false,
        ],
        [
            'type'         => 'darkmode-widget',
            'topnav_right' => true, // Or "topnav => true" to place on the left.
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar',
        ],
        [
            'text' => 'Web',
            'route'  => 'web',
            'icon'    => 'fas fa-laptop',
        ],
        [
            'text' => 'Panel',
            'route'  => 'dashboard',
            'icon'    => 'fas fa-tachometer-alt',
            'can'   => 'dashboard',
        ],
        ['header' => 'ADMINISTRACIÓN'],
        [
            'text'    => 'Productos',
            'icon'    => 'fas fa-shoe-prints',
            'can'   => ['producto.upload','producto.index','producto.estilos','marcas.index','proveedores.index','producto.stock-faltante'],
            'submenu' => [
                [
                    'text' => 'Carga',
                    'route'  => 'producto.upload',
                    'icon'    => 'ml-md-2 fas fa-cloud-upload-alt',
                    'can'   =>  'producto.upload',
                ],
                [
                    'text' => 'Lista Productos',
                    'route'  => 'productos.index',
                    'icon'    => 'ml-md-2 fas fa-box-open',
                    'can'   =>  'producto.index',
                ],
                [
                    'text' => 'Estilos y Color',
                    'route'  => 'producto.estilos',
                    'can'  => 'producto.estilos',
                    'icon'    => 'ml-md-2 fas fa-palette',
                ],
                [
                    'text'    => 'Marcas',
                    'icon'    => 'ml-md-2 fas fa-copyright',
                    'route'  => 'marcas.index',
                    'can'  => 'marcas.index',
                ],
                [
                    'text'    => 'Provedor',
                    'icon'    => 'ml-md-2 fas fa-truck',
                    'route'  => 'proveedores.index',
                    'can'  => 'proveedores.index',
                ],
                [
                    'text'    => 'Historial STOCK faltante',
                    'icon'    => 'ml-md-2 fas fa-boxes',
                    'route'  => 'producto.stock-faltante',
                    'can'  => 'producto.stock-faltante',
                ],
            ]
        ],
        [
            'text'    => 'Ventas',
            'icon'    => 'fas fa-shopping-cart',
            'can'     =>['venta.upload','ventas.index','venta.pedido','venta.pedidos-guardados'],
            'submenu' => [
                [
                    'text' => 'Carga',
                    'route'  => 'venta.upload',
                    'can'  => 'venta.upload',
                    'icon'    => 'ml-md-2 fas fa-cloud-upload-alt',
                ],
                [
                    'text' => 'Registro Ventas',
                    'route'  => 'ventas.index',
                    'can'  => 'venta.index',
                    'icon'    => 'ml-md-2 fas fa-chart-line',
                ],
                [
                    'text' => 'Tomar Pedidos',
                    'route'  => 'venta.pedido',
                    'can'  => 'venta.pedido',
                    'icon'    => 'ml-md-2 fas fa-tasks',
                ],
                [
                    'text' => 'Pedidos Guardados',
                    'route'  => 'venta.pedidos-guardados',
                    'can'  => 'venta.pedidos-guardados',
                    'icon'    => 'ml-md-2 fas fa-box',
                ],
                [
                    'text' => 'Cambios',
                    'route'  => 'venta.cambios',
                    'icon'    => 'ml-md-2 fas fa-arrows-alt-h',
                    'can'   =>  'producto.index',
                ],
                [
                    'text' => 'Cambios Guardados',
                    'route'  => 'cambio.cambios-reservados',
                    'can'  => 'cambio.cambios-reservados',
                    'icon'    => 'ml-md-2 fas fa-box',
                ],
                [
                    'text' => 'Registro de Cambios',
                    'route'  => 'cambio.index',
                    'can'  => 'venta.index',
                    'icon'    => 'ml-md-2 fas fa-chart-line',
                ],
            ],
        ],
        [
            'text'    => 'Catálogos',
            'icon'    => 'fas fa-book-open',
            'can'       =>['catalogos.index','catalogo.catalogoProducto','premios.index'],
            'submenu' => [
                [
                    'text' => 'Crear Catálogo',
                    'route'  => 'catalogos.index',
                    'can'  => 'catalogos.index',
                    'icon'    => 'ml-md-2 fas fa-folder-plus',
                ],
                [
                    'text' => 'Parametros',
                    'route'  => 'catalogo.parametros',
                    'can'  => 'catalogos.index',
                    'icon'    => 'ml-md-2 fas fa-folder-plus',
                ],
                [
                    'text' => 'Parametros Marca',
                    'route'  => 'catalogo.parametros-marca',
                    'can'  => 'catalogos.index',
                    'icon'    => 'ml-md-2 fas fa-folder-plus',
                ],
                // [
                //     'text' => 'Asignar Productos',
                //     'route'  => 'catalogo.catalogoProducto',
                //     'can'  => 'catalogo.catalogoProducto',
                //     'icon'    => 'ml-md-2 fas fa-book-reader',
                // ],
                [
                    'text' => 'Premios',
                    'route'  => 'premios.index',
                    'can'  => 'premios.index',
                    'icon'    => 'ml-md-2 fas fa-gifts',
                ],
                [
                    'text' => 'Ofertas',
                    'route'  => 'ofertas.index',
                    'can'  => 'premios.index',
                    'icon'    => 'ml-md-2 fas fa-tag',
                ]
            ],
        ],

        [
            'text'    => 'Usuarios',
            'icon'    => 'fas fa-users',
            'can'     => ['roles.index','usuario.index','empresarias.index'],
            'submenu' => [
                [
                    'text' => 'Lista de Roles',
                    'route'  => 'admin.roles.index',
                    'icon'    => 'ml-md-2 fas fa-user-cog',
                    'can'   => 'roles.index',
                ],
                [
                    'text' => 'Lista de Usuarios',
                    'route'  => 'usuario.index',
                    'icon'    => 'ml-md-2 fas fa-user-plus',
                    'can'   => 'usuario.index',
                ],
                [
                    'text'    => 'Empresarias',
                    'icon'    => 'ml-md-2 fab fa-slideshare',
                    'route'  => 'empresarias.index',
                    'can'   =>'empresarias.index',
                ],
            ]
        ],
        [
            'text'    => 'Reportes',
            'icon'    => 'fas fa-chart-pie',
            'can'     => ['reportes.index','reporte.graficos','reporte.ventas'],
            'submenu' => [
                [
                    'text' => 'Vendedor',
                    'route'  => 'reportes.index',
                    'can'  => 'reportes.index',
                    'icon'    => 'ml-md-2 fas fa-receipt'
                ],
                [
                    'text' => 'General',
                    'route'  => 'reporte.graficos',
                    'can'  => 'reporte.graficos',
                    'icon'    => 'ml-md-2 fas fa-chart-area'
                ],
                [
                    'text' => 'ventas',
                    'route'  => 'reporte.ventas',
                    'can'  => 'reporte.ventas',
                    'icon'    => 'ml-md-2 fas fa-file'
                ],
            ]
        ],

        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'user/profile',
            'icon' => 'fas fa-fw fa-user',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/datatables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/datatables.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
        'TempusDominusBs4' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'BootstrapSelect' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
