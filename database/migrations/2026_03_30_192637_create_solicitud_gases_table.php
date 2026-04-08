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
        Schema::create('solicitud_gases', function (Blueprint $table) {
            $table->id();
                $table->string('rut_funcionario');
                $table->string('nombre_funcionario');
                $table->string('estado');
                $table->integer('cantidadTotalVales')->nullable();
                $table->date('fecha_solicitud');
                $table->date('fecha_modificacion')->nullable();
                $table->date('fecha_entrega')->nullable();
                $table->integer('costo_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_gases');
    }
};
