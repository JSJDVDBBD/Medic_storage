<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name'=>'Administrador']);

        Permission::create(['name' => 'accesso puntos de venta'])->syncRoles([$role]);
        Permission::create(['name' => 'accesso a roles'])->syncRoles([$role]);
        Permission::create(['name' => 'accesso a administracion'])->syncRoles($role);
    }
}
