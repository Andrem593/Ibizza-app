<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiosAcumuladosEmpresaria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premios_acumulados_empresaria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalogo_id')->nullable();
            $table->foreign('catalogo_id')->references('id')->on('catalogos')->onDelete('set null');
            $table->unsignedBigInteger('empresaria_id')->nullable();
            $table->foreign('empresaria_id')->references('id')->on('empresarias')->onDelete('set null');
            $table->unsignedBigInteger('condicion_premio_id')->nullable();
            $table->foreign('condicion_premio_id')->references('id')->on('condicion_premios')->onDelete('set null');
            $table->unsignedBigInteger('venta_id');
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('premios_acumulados_empresaria');
    }
}
