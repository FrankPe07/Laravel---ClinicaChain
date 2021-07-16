<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionMedicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_medica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calendario_id');
            $table->foreign('calendario_id')->references('id')->on('calendario');
            $table->unsignedBigInteger('medico_id');
            $table->foreign('medico_id')->references('id')->on('medico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programacion_medica');
    }
}
