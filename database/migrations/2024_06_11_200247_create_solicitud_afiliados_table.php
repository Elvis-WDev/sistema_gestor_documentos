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
        Schema::create('solicitud_afiliados', function (Blueprint $table) {
            $table->id('id_solicitudAfiliados');
            $table->string('Archivo', 255);
            $table->string('Prefijo', 50)->unique()->default('');
            $table->text('NombreCliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_afiliados');
    }
};
