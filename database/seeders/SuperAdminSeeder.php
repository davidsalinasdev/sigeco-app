<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::create([
            'name' => 'RODRIGO PINTO CRISPIN', //'Amalia Vila',
            'email' => 'rpintoc1', //'amalia@admin.com',
            //'password' => bcrypt('rpintoc1'), //bcrypt('12345678'),

            'idExt' => 4069,
            'idServidor' => 4221,
            'ci' => '000000000070',
            'nombres' => 'RODRIGO',
            'paterno' => 'PINTO',
            'materno' => 'CRISPIN',
            'celular' => '4500530',
            'domicilio' => 'Av. Aroma frente Plazuela San Sebastian',
            'estado' => 't',
            'cargo' => 'PROFESIONAL II',
            'dependencia' => 'GADC UNIDAD DE GOBIERNO ELECTRÓNICO',
  
        ]);

        $rol = Role::create([
            'name' => 'Administrador',
        ]);

        $permisos = Permission::pluck('id', 'id')->all();

        $rol->syncPermissions($permisos);

        $usuario->assignRole([$rol->id]);
    }
}
