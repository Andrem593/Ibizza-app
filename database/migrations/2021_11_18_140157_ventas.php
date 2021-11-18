<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ventas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_vendedor');
            $table->integer('id_empresaria');
            $table->string('direccion_envio');
            $table->string('observaciones');
            $table->integer('id_pedido');
            $table->integer('cantidad_total');
            $table->float('total_venta',8,2);
            $table->float('total_p_empresaria',8,2);
            $table->string('estado');            
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
        Schema::dropIfExists('Ventas');
    }
}
