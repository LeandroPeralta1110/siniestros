<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class addPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     // Encuentra el usuario al que deseas asignar permisos
     $user = User::where('email', 'leandroemmanuel_99@outlook.es')->first();

     // Encuentra los permisos que deseas asignar al usuario
     $permissions = Permission::whereIn('name', [
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
     ])->get();

     // Asigna los permisos al usuario
     $user->givePermissionTo($permissions);
    }
}
