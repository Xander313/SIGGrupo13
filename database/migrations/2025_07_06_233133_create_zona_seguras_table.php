<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zona_seguras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('radio', 8, 2); // o más precisión si manejas radios grandes
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->string('tipo_seguridad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_seguras');
    }
};
