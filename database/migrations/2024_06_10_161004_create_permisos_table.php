<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id('id_permiso');
            $table->foreignId('id_rol')->constrained('roles', 'id_rol')->onDelete('cascade');
            $table->string('Permiso_facturas')->default('[]');
            $table->string('Permiso_pagos')->default('[]');
            $table->string('Permiso_NotasCredito')->default('[]');
            $table->string('Permiso_CartasAfiliacion')->default('[]');
            $table->string('Permiso_Retenciones')->default('[]');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permisos');
    }
};
