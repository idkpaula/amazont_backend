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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_prod');
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
            $table->boolean('en_oferta')->default(false);
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('categoria_id'); 
            $table->foreign('categoria_id')->references('id_cat')->on('categorias')->onDelete('cascade'); // Relación con la columna id_cat
            $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
