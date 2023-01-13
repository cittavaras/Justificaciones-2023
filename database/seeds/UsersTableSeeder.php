<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create();

        Role::create([
          'name'    => 'Admin',
          'slug'    => 'admin',
          'special' => 'all-access',
        ]);

        User::create([
          'name'     => 'Alejandro Del Pino',
          'email'    => 'al.delpino@alumnos.duoc.cl',
          'rol'      => 'alumno',
          'password' => '$2y$10$s4modcBdM1Hmul3RMDaVhuSIjuVQwWVEl4U489m3lIob1286IZFjW' //holamundo
        ]);

        User::create([
          'name'     => 'Jonathan Casitillo',
          'email'    => 'j.castillo@duoc.cl',
          'rol'      => 'admin',
          'password' => '$2y$10$s4modcBdM1Hmul3RMDaVhuSIjuVQwWVEl4U489m3lIob1286IZFjW' //holamundo
        ]);

        User::create([
          'name'     => 'Fernando Arriagada',
          'email'    => 'f.arriagada@duoc.cl',
          'rol'      => 'coordinador',
          'password' => '$2y$10$s4modcBdM1Hmul3RMDaVhuSIjuVQwWVEl4U489m3lIob1286IZFjW' //holamundo
        ]);
    }
}
