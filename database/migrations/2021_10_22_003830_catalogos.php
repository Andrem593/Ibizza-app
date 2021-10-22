<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Catalogos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catalogos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->text('descripcion');
            $table->string('foto_path', 50)->nullable();
            $table->string('pdf_path', 50)->nullable();
            $table->datetime('fecha_publicacion')->nullable();
            $table->datetime('fecha_fin_catalogo')->nullable();
            $table->char('estado', 1)->default('A');
            $table->integer('premio_id')->nullable();
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
