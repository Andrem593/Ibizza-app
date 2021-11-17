<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Empresarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cedula',10);
            $table->string('nombres',50);
            $table->string('apellidos',50);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->char('estado',1)->default('A');;
            $table->string('telefono')->nullable();
            $table->integer('id_ciudad');
            $table->integer('vendedor');
            $table->integer('id_user');
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
