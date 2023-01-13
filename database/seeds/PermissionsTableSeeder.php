<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Alumno
        Permission::create([
          'name'        => 'Navegar Alumno',
          'slug'        => 'alumno.index',
          'description' => 'Lista y Navega los Justificativos del usuario',
        ]);

        Permission::create([
          'name'        => 'Crear justificativo',
          'slug'        => 'alumno.create',
          'description' => 'Alumno crea justificativo',
        ]);

        Permission::create([
          'name'        => 'Ver detalle del justificativo',
          'slug'        => 'alumno.show',
          'description' => 'Alumno ve detalle justificativo',
        ]);

        //Roles

        Permission::create([
          'name'        => 'Navegar Roles',
          'slug'        => 'roles.index',
          'description' => 'Lista y Navega los roles',
        ]);

        Permission::create([
          'name'        => 'Crear Roles',
          'slug'        => 'roles.create',
          'description' => 'Creacion de roles',
        ]);

        Permission::create([
          'name'        => 'Ver detalle de Roles',
          'slug'        => 'roles.show',
          'description' => 'Ver en detalle un rol',
        ]);

        Permission::create([
          'name'        => 'Edicion de Roles',
          'slug'        => 'roles.edit',
          'description' => 'Edicion de roles',
        ]);

        Permission::create([
          'name'        => 'Elimincion de Roles',
          'slug'        => 'roles.destroy',
          'description' => 'Eliminacion de roles',
        ]);

        //Coordinador

        Permission::create([
          'name'        => 'Navegar Justificativos',
          'slug'        => 'coordinador.index',
          'description' => 'Lista y Navega los roles',
        ]);

        Permission::create([
          'name'        => 'Crear Roles',
          'slug'        => 'coordinador.create',
          'description' => 'Creacion de roles',
        ]);

        Permission::create([
          'name'        => 'Ver detalle de Justificativos',
          'slug'        => 'coordinador.show',
          'description' => 'Ver en detalle un rol',
        ]);

        Permission::create([
          'name'        => 'Edicion de Justificativos',
          'slug'        => 'coordinador.edit',
          'description' => 'Edicion de roles',
        ]);

        Permission::create([
          'name'        => 'Elimincion de Justificativos',
          'slug'        => 'coordinador.destroy',
          'description' => 'Eliminacion de roles',
        ]);
    }
}
