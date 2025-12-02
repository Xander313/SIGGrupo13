<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('TipoAtraccion', function (Blueprint $table) {
            $table->increments('IdTipoAtraccion');
            $table->string('NombreTipoAtraccion', 150)->unique();
            $table->string('NivelPopularidad', 150);
            $table->string('RequiereGuia', 150);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('TipoAtraccion');
    }
};
