<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id('id_valoracion');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('usuario_id');
            $table->integer('puntuacion'); // Valor de 1 a 5
            $table->timestamps();

            $table->foreign('producto_id')->references('id_prod')->on('productos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('valoraciones');
    }
};
