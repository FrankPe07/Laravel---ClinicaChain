<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',40);
            $table->string('apellidos',80);
            $table->boolean('genero')->nullable();
            $table->string('domicilio',100)->nullable();
            $table->string('dni',10)->nullable();
            $table->string('ocupacion',20)->nullable();
            $table->string('lugar_nacimiento',60)->nullable();
            $table->datetime('fecha_nacimiento')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('persona');
    }
}
