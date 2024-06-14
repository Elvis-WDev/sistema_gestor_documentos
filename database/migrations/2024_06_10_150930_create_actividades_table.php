<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id('id_actividad');
            $table->foreignId('id_usuario')->constrained('users', 'id')->onDelete('cascade');
            $table->string('Accion', 50);
            $table->string('Detalles', 255)->nullable();
            $table->timestamp('FechaHora')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};