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
        // Creación de la tabla roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_rol');
            $table->enum('Rol', ['SuperAdmin', 'Administrador', 'Usuario'])->default('Usuario');
            $table->timestamps();
        });

        // Creación de la tabla usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('Nombres', 100)->default('');
            $table->string('Apellidos', 100)->default('');
            $table->string('NombreUsuario', 100)->unique()->default('');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('url_img');
            $table->foreignId('id_rol')->default(1)->constrained('roles', 'id_rol')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
