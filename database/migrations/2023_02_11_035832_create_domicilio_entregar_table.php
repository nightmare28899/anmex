<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilio_entregar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domicilio');
            $table->string('cp');
            $table->string('telefono');
            $table->string('observaciones');
            $table->integer('cliente_id');
            $table->string('fechaActual');
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
        Schema::dropIfExists('domicilio_entregar');
    }
};
