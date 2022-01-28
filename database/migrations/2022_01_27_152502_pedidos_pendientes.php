<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PedidosPendientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_pendientes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_separados');
            $table->integer('id_producto');
            $table->integer('cantidad');
            $table->float('precio',8,2);
            $table->float('total',8,2);
            $table->string('estado');
            $table->integer('usuario');
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
        Schema::dropIfExists('pedidos_pendientes');
    }
}
