<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = Role::create(['name' => 'SuperAdmin']);

        $permissions = [
            'ver usuario',
            'crear usuario',
            'modificar usuario',
            'ver facturas',
            'crear facturas',
            'modificar facturas',
            'ver pagos',
            'crear pagos',
            'modificar pagos',
            'ver NotasCredito',
            'crear NotasCredito',
            'modificar NotasCredito',
            'ver SolicitudAfiliado',
            'crear SolicitudAfiliado',
            'modificar SolicitudAfiliado',
            'ver retenciones',
            'crear retenciones',
            'modificar retenciones',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar todos los permisos a SuperAdmin
        $superAdmin->givePermissionTo(Permission::all());
    }
}
