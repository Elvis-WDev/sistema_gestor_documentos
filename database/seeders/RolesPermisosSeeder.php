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
            'ver facturas',
            'ver establecimiento',
            'ver punto_emision',
            'ver pagos',
            'ver NotasCredito',
            'ver SolicitudAfiliado',
            'ver retenciones',
            'ver custom_module',
            'crear usuario',
            'crear facturas',
            'crear establecimiento',
            'crear punto_emision',
            'crear pagos',
            'crear NotasCredito',
            'crear SolicitudAfiliado',
            'crear retenciones',
            'crear custom_module',
            'modificar usuario',
            'modificar facturas',
            'modificar establecimiento',
            'modificar punto_emision',
            'modificar pagos',
            'modificar NotasCredito',
            'modificar SolicitudAfiliado',
            'modificar retenciones',
            'modificar custom_module',
            'eliminar usuario',
            'eliminar facturas',
            'eliminar establecimiento',
            'eliminar punto_emision',
            'eliminar pagos',
            'eliminar NotasCredito',
            'eliminar SolicitudAfiliado',
            'eliminar retenciones',
            'eliminar custom_module',
            'configuraciones',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar todos los permisos a SuperAdmin
        $superAdmin->givePermissionTo(Permission::all());
    }
}
