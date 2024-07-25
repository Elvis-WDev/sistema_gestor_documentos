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
            $table->foreignId('id_factura')->constrained('facturas', 'id_factura')->onDelete('restrict');
            $table->string('Archivos', 1000)->default('[]');
            $table->decimal('Total', 10, 2)->default(0);
            $table->dateTime('FechaPago');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
