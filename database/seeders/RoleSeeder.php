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
        Permission::create([
            'name' => 'usuario.create',
            'description' => 'Crear Usuarios'
        ])->syncRoles([$role1]);
    }
}
