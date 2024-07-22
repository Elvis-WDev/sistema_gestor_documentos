<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modulos_personalizados', function (Blueprint $table) {
            $table->id('id_modulo');
            $table->string('NombreModulo', 50);
            $table->unsignedBigInteger('id_usuario');
            $table->enum('Estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modulos_personalizados');
    }
};