<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateJustificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('justificaciones', function (Blueprint $table) {
            $table->increments('id_justificaciones');
            $table->string('nombreAlumno')->nullable();
            $table->string('correoAlumno')->nullable();
            $table->string('fechaJustificacion')->default(Carbon::now());
            $table->string('asignatura')->nullable();
            $table->string('tipoInasistencia')->nullable();
            $table->string('motivo')->nullable();
            $table->string('estado')->default('validando');
            $table->string('comentario')->nullable();
            $table->string('correoCoordinador')->nullable();
            $table->string('correoDocente')->nullable();
            $table->string('motivoRechazo')->default('Ninguno');
            $table->string('comentarioRechazo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('justificaciones');
    }
}
