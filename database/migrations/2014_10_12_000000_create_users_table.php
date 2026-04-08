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
            $table->string('name');
            $table->string('rut')->unique()->default('18755610-4');;
            $table->integer('id_cargo')->nullable();
             $table->integer('id_area')->nullable();
             $table->integer('id_departamento')->nullable();
             $table->integer('telefono')->nullable();
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
