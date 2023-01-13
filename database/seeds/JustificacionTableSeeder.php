<?php

use Illuminate\Database\Seeder;

class JustificacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Justificacion::class, 80)->create();
    }
}
