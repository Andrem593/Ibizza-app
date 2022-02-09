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
            'description' => 'Carga de Productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.index',
            'description' => 'Lista de Productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.estilos',
            'description' => 'Estilos de Productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'marcas.index',
            'description' => 'Lista de Marcas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'proveedores.index',
            'description' => 'Lista de proveedores'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'producto.stock-faltante',
            'description' => 'Historial de stock faltante'
        ])->syncRoles([$role1]);

        // Modulo Ventas

        Permission::create([
            'name' => 'venta.upload',
            'description' => 'Carga de Ventas Facturadas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.index',
            'description' => 'Registros de ventas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.pedido',
            'description' => 'Toma de pedidos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'venta.pedidos-guardados',
            'description' => 'Pedidos guardados'
        ])->syncRoles([$role1]);

        // modulo de catalogos

        Permission::create([
            'name' => 'catalogos.index',
            'description' => 'Crear catálogos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'catalogo.catalogoProducto',
            'description' => 'Asignar Productos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'premios.index',
            'description' => 'Administración de Premios'
        ])->syncRoles([$role1]);        
        
        // MODULO DE USUARIOS

        Permission::create([
            'name' => 'roles.index',
            'description' => 'Administración de Roles'
        ])->syncRoles([$role1]);   
        Permission::create([
            'name' => 'usuario.index',
            'description' => 'Administración de Usuarios'
        ])->syncRoles([$role1]);  
        Permission::create([
            'name' => 'empresarias.index',
            'description' => 'Administración de Empresarias'
        ])->syncRoles([$role1]);  

        // MODULO DE REPORTES

        Permission::create([
            'name' => 'reportes.index',
            'description' => 'Reportes de Vendedor'
        ])->syncRoles([$role1]);  
        Permission::create([
            'name' => 'reporte.graficos',
            'description' => 'Reportes Administrativos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'reporte.ventas',
            'description' => 'Reportes de Ventas'
        ])->syncRoles([$role1]);
    }
}
