<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentescoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parentesco', function (Blueprint $table) {
            $table->id();
            $table->string('description');
        });
        DB::table('parentesco')->insert(['description' => 'Padre']);
        DB::table('parentesco')->insert(['description' => 'Madre']);
        DB::table('parentesco')->insert(['description' => 'Hijo']);
        DB::table('parentesco')->insert(['description' => 'Hija']);
        DB::table('parentesco')->insert(['description' => 'Tio']);
        DB::table('parentesco')->insert(['description' => 'Tia']);
        DB::table('parentesco')->insert(['description' => 'Abuelo']);
        DB::table('parentesco')->insert(['description' => 'Abuela']);
        DB::table('parentesco')->insert(['description' => 'Esposo']);
        DB::table('parentesco')->insert(['description' => 'Esposa']);
        DB::table('parentesco')->insert(['description' => 'Primo']);
        DB::table('parentesco')->insert(['description' => 'Prima']);
        DB::table('parentesco')->insert(['description' => 'Hermano']);
        DB::table('parentesco')->insert(['description' => 'Hermana']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parentesco');
    }
}
