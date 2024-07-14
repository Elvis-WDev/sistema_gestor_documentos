<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('columnas_personalizadas', function (Blueprint $table) {
            $table->id('id_columna');
            $table->foreignId('id_modulo')->constrained('modulos_personalizados', 'id_modulo')->onDelete('restrict');
            $table->string('NombreColumna', 50);
            $table->string('TipoDato', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('columnas_personalizadas');
    }
};
