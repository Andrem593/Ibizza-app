<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('categoria_id');
            $table->foreignId('marca_id')->constrained();
            $table->string('descripcion');
            $table->string('linea');
            $table->string('color');
            $table->string('nombre_color');
            $table->float('precio', 8, 2);
            $table->float('descuento', 8, 2);
            $table->string('sku');
            $table->integer('cantidad');
            $table->integer('stock_inicial');
            $table->string('coleccion');
            $table->date('fecha_entrega');
            $table->string('status_fabrica');
            $table->string('vigencia')->default('ACTIVO');
            $table->text('observacion');
            $table->float('pvp', 8, 2);
            $table->string('imagen');
            $table->string('status_imagen')->default(0);
            $table->float('precio_mayorista', 8, 2);
            $table->string('modelo');
            $table->string('numero_pedido');
            $table->integer('proveedor_id')->nullable(false);
            $table->string('clasificacion');
            
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
        //
    }
}
