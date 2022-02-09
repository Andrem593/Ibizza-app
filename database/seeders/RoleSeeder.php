<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'empresaria']);

        Permission::create([
            'name' => 'dashboard',
            'description' => 'Ver dashboard'            
        ])->syncRoles([$role1]);

        // Modulo Producto

        Permission::create([
            'name' => 'producto.upload',
            'description' => 'Carga de Productos',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.index',
            'description' => 'Lista de Productos',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.estilos',
            'description' => 'Estilos de Productos',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'marcas.index',
            'description' => 'Lista de Marcas',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'proveedores.index',
            'description' => 'Lista de proveedores',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.stock-faltante',
            'description' => 'Historial de stock faltante',
            'categoria' => 'productos'
        ])->syncRoles([$role1]);

        // Modulo Ventas

        Permission::create([
            'name' => 'venta.upload',
            'description' => 'Carga de Ventas Facturadas',
            'categoria' => 'ventas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.index',
            'description' => 'Registros de ventas',
            'categoria' => 'ventas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.pedido',
            'description' => 'Toma de pedidos',
            'categoria' => 'ventas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.pedidos-guardados',
            'description' => 'Pedidos guardados',
            'categoria' => 'ventas'
        ])->syncRoles([$role1]);

        // modulo de catalogos

        Permission::create([
            'name' => 'catalogos.index',
            'description' => 'Crear catálogos',
            'categoria' => 'catalogos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'catalogo.catalogoProducto',
            'description' => 'Asignar Productos',
            'categoria' => 'catalogos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'premios.index',
            'description' => 'Administración de Premios',
            'categoria' => 'catalogos'
        ])->syncRoles([$role1]);        
        
        // MODULO DE USUARIOS

        Permission::create([
            'name' => 'roles.index',
            'description' => 'Administración de Roles',
            'categoria' => 'usuarios'
        ])->syncRoles([$role1]);   
        Permission::create([
            'name' => 'usuario.index',
            'description' => 'Administración de Usuarios',
            'categoria' => 'usuarios'
        ])->syncRoles([$role1]);  
        Permission::create([
            'name' => 'empresarias.index',
            'description' => 'Administración de Empresarias',
            'categoria' => 'usuarios'
        ])->syncRoles([$role1]);  

        // MODULO DE REPORTES

        Permission::create([
            'name' => 'reportes.index',
            'description' => 'Reportes de Vendedor',
            'categoria' => 'reportes'
        ])->syncRoles([$role1]);  
        Permission::create([
            'name' => 'reporte.graficos',
            'description' => 'Reportes Administrativos',
            'categoria' => 'reportes'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'reporte.ventas',
            'description' => 'Reportes de Ventas',
            'categoria' => 'reportes'
        ])->syncRoles([$role1]);
    }
}
