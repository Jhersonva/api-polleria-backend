<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        Mejoras que se podria realizar:
        - Agregar un campo para el tipo (is_active) control de estado: $table->boolean('is_active')->default(true);
        - Agregar un campo de tipo (last_login_at) para el último inicio de sesión: $table->timestamp('last_login_at')->nullable();
        */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
