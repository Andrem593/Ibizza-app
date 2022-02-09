<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogStockFaltantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_stock_faltantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_mostrar')->nullable();
            $table->string('estilo',100)->nullable();
            $table->string('color',100)->nullable();
            $table->string('talla')->nullable();
            $table->integer('stock_requerido')->nullable();
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
