<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('punto_encuentros', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->integer('capacidad');
        $table->decimal('latitud', 10, 7);
        $table->decimal('longitud', 10, 7);
        $table->string('responsable');
        $table->timestamps();
    });
}
    /**
     */
    public function down(): void
    {
        Schema::dropIfExists('punto_encuentros');
    }
};
