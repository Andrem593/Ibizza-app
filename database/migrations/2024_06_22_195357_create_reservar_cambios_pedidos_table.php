<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservarCambiosPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservar_cambios_pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_vendedor')->unsigned();
            $table->date('fecha');
            $table->integer('id_empresaria')->unsigned();
            $table->string('motivo', 50)->nullable();
            $table->string('descripcion', 50)->nullable();
            $table->string('f_nombre', 50)->nullable();
            $table->string('f_cedula', 50)->nullable();
            $table->string('f_telefono', 50)->nullable();
            $table->string('f_correo', 50)->nullable();
            $table->string('e_nombre', 50)->nullable();
            $table->string('e_cedula', 50)->nullable();
            $table->string('e_telefono', 50)->nullable();
            $table->string('e_provincia', 50)->nullable();
            $table->string('e_ciudad', 50)->nullable();
            $table->string('e_direccion', 50)->nullable();
            $table->string('obervaciones', 100)->nullable();
            $table->string('e_pedido', 50)->nullable();
            $table->float('envio')->nullable();
            $table->integer('id_venta')->unsigned()->nullable();
            $table->integer('id_pedido')->unsigned()->nullable();
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
        Schema::dropIfExists('reservar_cambios_pedidos');
    }
}
