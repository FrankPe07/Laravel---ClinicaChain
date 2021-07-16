<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResenaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resena', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cita_id');
            $table->foreign('cita_id')->references('id')->on('cita');
            $table->string('calificacion');
            $table->string('opinion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resena');
    }
}
