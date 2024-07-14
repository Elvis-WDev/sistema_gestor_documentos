<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up(): void
    {
        Schema::create('establecimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->timestamps();
        });

        Schema::create('puntos_emision', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establecimiento_id');
            $table->string('nombre', 50);
            $table->timestamps();

            // Corrected foreign key definition
            $table->foreign('establecimiento_id')->references('id')->on('establecimientos')->onDelete('restrict');
        });

        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->string('Archivos', 1000)->default('');
            $table->dateTime('FechaEmision');
            $table->unsignedBigInteger('punto_emision_id');
            $table->unsignedBigInteger('establecimiento_id');
            $table->string('Secuencial', 50)->default('');
            $table->decimal('RetencionIva', 10, 2)->default(0);
            $table->decimal('RetencionFuente', 10, 2)->default(0);
            $table->string('Abono', 500)->default('');
            $table->string('RazonSocial', 255);
            $table->decimal('Total', 10, 2);
            $table->enum('Estado', ['Pagada', 'Anulada', 'Abonada', 'Registrada'])->default('Registrada');
            $table->timestamps();

            // Corrected foreign key definitions
            $table->foreign('punto_emision_id')->references('id')->on('puntos_emision')->onDelete('restrict');
            $table->foreign('establecimiento_id')->references('id')->on('establecimientos')->onDelete('restrict');
        });

        Schema::create('abonos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factura_id');
            $table->decimal('valor_abono', 10, 2);
            $table->decimal('total_factura', 10, 2);
            $table->decimal('saldo_factura', 10, 2);
            $table->timestamp('fecha_abonado');
            $table->timestamps();

            $table->foreign('factura_id')->references('id_factura')->on('facturas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('puntos_emision');
        Schema::dropIfExists('establecimientos');
    }
};
