<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Provincia', function (Blueprint $table) {
            $table->increments('IdProvincia');
            $table->string('NombreProvincia', 100)->unique();
            $table->string('Capital', 100);
            $table->integer('Poblacion');
            $table->string('ClimaPredominante', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Provincia');
    }
};
