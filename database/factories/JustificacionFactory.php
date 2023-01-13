<?php

use Faker\Generator as Faker;

  $factory->define(App\Justificacion::class, function (Faker $faker) {
    return [
      'nombreAlumno' => $faker->sentence,
      'correoAlumno' => $faker->sentence,
      'fechaJustificacion' => $faker->sentence,
      'asignatura' => $faker->sentence,
      'tipoInasistencia' => $faker->sentence,
      'motivo' => $faker->sentence,
      'estado' => $faker->sentence,
      'comentario' => $faker->sentence,
      'correoCoordinador' => $faker->sentence,
      'correoDocente' => $faker->sentence,
      'motivoRechazo' => $faker->sentence,
      'comentarioRechazo' => $faker->sentence
    ];
});
