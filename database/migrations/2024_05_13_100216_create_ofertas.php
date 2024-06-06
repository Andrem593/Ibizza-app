<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->string('oferta', 100);
            $table->integer('catalogo_id');
            $table->foreign('catalogo_id')->references('id')->on('catalogos');
            $table->integer('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->integer('tipo_oferta');
            $table->json('productos')->nullable();
            $table->float('desde', 8, 2)->nullable();
            $table->float('valor', 8, 2)->nullable();
            $table->integer('tipo_premio');
            $table->json('premios')->nullable();
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
        Schema::dropIfExists('ofertas');
    }
}
