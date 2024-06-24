<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservarCambiosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservar_cambios_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_reservar_cambio_pedido');
            $table->foreign('id_reservar_cambio_pedido')->references('id')->on('reservar_cambios_pedidos')->onDelete('set null');
            $table->integer('id_producto');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('set null');
            $table->integer('cantidad');
            $table->integer('diferencia');
            $table->integer('fecha');
            $table->integer('hora');
            $table->integer('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('set null');
            $table->decimal('precio', 10, 2);
            $table->decimal('precio_catalogo', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('descuento', 10, 2);
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
        Schema::dropIfExists('reservar_cambios_detalles');
    }
}
