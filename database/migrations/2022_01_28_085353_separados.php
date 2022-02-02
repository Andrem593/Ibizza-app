<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Separados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separados', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('cantidad_total');
            $table->float('total_venta',8,2);
            $table->float('total_p_empresaria',8,2);
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
        Schema::dropIfExists('separados');
    }
}
