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
            $table->string('sku');
            $table->string('imagen_path')->nullable();;
            $table->string('nombre_producto');
            $table->string('descripcion')->nullable();
            
            $table->string('marca_id')->nullable();
            $table->string('grupo',100)->nullable();
            $table->string('seccion',100)->nullable();
            $table->string('clasificacion',100)->nullable();
            $table->integer('proveedor_id');
            $table->string('estilo',100)->nullable();
            $table->string('color',100)->nullable();
            $table->string('talla')->nullable();
            $table->integer('cantidad_inicial')->nullable();
            $table->integer('stock')->nullable();
            
            $table->float('valor_venta', 8, 2)->nullable();
            $table->datetime('ultima_venta')->nullable();
            $table->char('estado', 1)->default('A');
            
            $table->string('nombre_mostrar')->nullable();
            $table->string('categoria')->nullable();
            $table->string('subcategoria')->nullable();
            $table->float('descuento', 8, 2)->nullable();
            $table->float('precio_empresaria', 8, 2)->nullable();

            
            
            
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
