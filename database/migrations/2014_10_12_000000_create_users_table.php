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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_materno');
            $table->string('apellido_paterno');
            $table->string('rut')->unique();
            $table->integer('id_direccion')->nullable();
            $table->integer('id_area')->nullable();
            $table->string('telefono')->nullable();
            $table->integer('id_calidadJuridica')->nullable();
            $table->string('email')->unique();
            $table->enum('role', ['superadmin','admin', 'funcionario'])->default('funcionario');
            $table->string('password');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
