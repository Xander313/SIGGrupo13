<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('LugarTuristico_2FN', function (Blueprint $table) {
            $table->increments('IdLugarTuristico');
            $table->string('NombreLugar', 200);

            $table->unsignedInteger('IdProvincia');
            $table->unsignedInteger('IdTipoAtraccion');

            $table->decimal('Latitud', 10, 6);
            $table->decimal('Longitud', 10, 6);
            $table->longText('Descripcion');
            $table->integer('AnioCreacion');
            $table->string('Accesibilidad', 50);

            // Foreign Keys
            $table->foreign('IdProvincia')
                  ->references('IdProvincia')
                  ->on('Provincia');

            $table->foreign('IdTipoAtraccion')
                  ->references('IdTipoAtraccion')
                  ->on('TipoAtraccion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LugarTuristico_2FN');
    }
};
