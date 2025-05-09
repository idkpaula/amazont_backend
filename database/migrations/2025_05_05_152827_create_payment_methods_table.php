<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('payment_methods', function (Blueprint $table) {
        $table->id('id_metodo');
        $table->unsignedBigInteger('user_id');
        $table->enum('tipo', ['tarjeta', 'paypal']);
        $table->string('nombre')->nullable();
        $table->string('num_tarjeta')->nullable();
        $table->string('fecha_caducidad')->nullable();
        $table->string('codigo_validacion')->nullable();
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
