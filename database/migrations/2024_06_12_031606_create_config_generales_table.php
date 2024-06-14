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
        Schema::create('config_generales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('archivos_permitidos');
            $table->integer('cantidad_permitidos');
            $table->integer('tamano_maximo_permitido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_generales');
    }
};