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
            $table->string('NombreModulo', 50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modulos_personalizados');
    }
};
