<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos_modulos_personalizados', function (Blueprint $table) {
            $table->id('id_archivo');
            $table->foreignId('id_modulo')->constrained('modulos_personalizados', 'id_modulo')->onDelete('restrict');
            $table->string('Archivo', 255);
            $table->date('Fecha');
            $table->string('TipoArchivo', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_modulos_personalizados');
    }
};