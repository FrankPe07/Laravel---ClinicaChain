<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialClinicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->string('motivo_consulta');
            $table->string('signo_sintomas');
            $table->string('diagnostico');
            $table->string('tratamiento');
            $table->integer('cita_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_clinico');
    }
}
