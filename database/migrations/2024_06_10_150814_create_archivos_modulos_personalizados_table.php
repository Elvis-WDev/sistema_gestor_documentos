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
            $table->string('Nombre', 255)->unique();
            $table->unsignedBigInteger('id_modulo');
            $table->unsignedBigInteger('id_usuario');
            $table->string('Archivo', 60);
            $table->string('extension', 5);
            $table->enum('Estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();

            $table->foreign('id_modulo')->references('id_modulo')->on('modulos_personalizados')->onDelete('restrict');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos_modulos_personalizados');
    }
};