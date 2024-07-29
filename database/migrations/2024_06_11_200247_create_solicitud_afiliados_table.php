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
            $table->id();
            $table->string('Archivos', 1000)->default('[]');
            $table->string('Prefijo', 50)->default('');
            $table->string('NombreCliente', 255)->default('');
            $table->datetime('FechaSolicitud');
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
