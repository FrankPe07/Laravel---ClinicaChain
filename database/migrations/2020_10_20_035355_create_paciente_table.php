<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->string('grupo_sanguineo')->nullable();
            $table->unsignedBigInteger('familia_id')->nullable();
            $table->unsignedBigInteger('parentesco_id');
            $table->string('num_historial')->nullable();
            $table->foreign('persona_id')->references('id')->on('persona');
            $table->foreign('familia_id')->references('id')->on('paciente');
            $table->foreign('parentesco_id')->references('id')->on('parentesco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paciente');
    }
}
