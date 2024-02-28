<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear o verificar el rol admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crear o actualizar permisos para el rol admin
        $adminPermissions = [
            'create-supervisores',
            'editar-supervisores',
            'eliminar-supervisores',
            'ver-supervisores',
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'ver-usuarios',
            'crear-formularios',
            'editar-formularios',
            'eliminar-formularios',
            'ver-formularios',
            // Agregar más permisos según sea necesario
        ];
        $this->syncPermissions($adminRole, $adminPermissions);

        // Crear o verificar el rol supervisor
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor']);

        // Crear o actualizar permisos para el rol supervisor
        $supervisorPermissions = [
            'crear-usuarios',
            'editar-usuarios',
            'eliminar-usuarios',
            'ver-usuarios',
            'crear-formularios',
            'editar-formularios',
            'eliminar-formularios',
            'ver-formularios',
            // Agregar más permisos para supervisor según sea necesario
        ];
        $this->syncPermissions($supervisorRole, $supervisorPermissions);

        // Crear o verificar el rol usuario
        $usuarioRole = Role::firstOrCreate(['name' => 'usuario']);

        // Crear o actualizar permisos para el rol usuario
        $usuarioPermissions = [
            'cargar-datos-formulario',
            'crear-formularios',
            'ver-formularios',
            // Agregar más permisos para usuario según sea necesario
        ];
        $this->syncPermissions($usuarioRole, $usuarioPermissions);
    }

    /**
     * Synchronize permissions for a role.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @param  array  $permissions
     * @return void
     */
    protected function syncPermissions(Role $role, array $permissions)
    {
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $role->givePermissionTo($permission);
        }
    }
}
