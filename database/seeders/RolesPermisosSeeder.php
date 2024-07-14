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
            'crear usuario',
            'crear facturas',
            'crear establecimiento',
            'crear punto_emision',
            'crear pagos',
            'crear NotasCredito',
            'crear SolicitudAfiliado',
            'crear retenciones',
            'modificar usuario',
            'modificar facturas',
            'modificar establecimiento',
            'modificar punto_emision',
            'modificar pagos',
            'modificar NotasCredito',
            'modificar SolicitudAfiliado',
            'modificar retenciones',
            'eliminar usuario',
            'eliminar facturas',
            'eliminar establecimiento',
            'eliminar punto_emision',
            'eliminar pagos',
            'eliminar NotasCredito',
            'eliminar SolicitudAfiliado',
            'eliminar retenciones',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar todos los permisos a SuperAdmin
        $superAdmin->givePermissionTo(Permission::all());
    }
}
