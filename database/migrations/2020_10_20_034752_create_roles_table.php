<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30)->unique();
            $table->string('description',50)->nullable();
            $table->boolean('condicion')->default(1);
        });

            DB::table('roles')->insert(['nombre' => 'Administrador', 'description' => 'Administrador']);
            DB::table('roles')->insert(['nombre' => 'Paciente', 'description' => 'Paciente']);
            DB::table('roles')->insert(['nombre' => 'Medico', 'description' => 'Medico']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
