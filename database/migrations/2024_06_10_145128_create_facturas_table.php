<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->string('Archivo', 255);
            $table->date('FechaEmision');
            $table->string('Establecimiento', 50);
            $table->string('PuntoEmision', 50);
            $table->string('Secuencial', 50);
            $table->string('RazonSocial', 100);
            $table->decimal('Total', 10, 2);
            $table->enum('Estado', ['Pagada', 'Anulada', 'Abonada'])->default('Pagada');
            $table->decimal('Abono', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
