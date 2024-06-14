<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->string('Archivo', 255);
            $table->decimal('Total', 10, 2);
            $table->date('Fecha');
            $table->timestamps();
            $table->foreignId('id_factura')->constrained('facturas', 'id_factura')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
