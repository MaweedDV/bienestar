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
        Schema::create('detalle_solicitudes', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('id_tipo_gas');
                $table->string('codigo_gas')->nullable();
                $table->integer('valor_unitario')->nullable();
                //id clave foranea
                $table->foreignId('solicitud_gas_id')->constrained('solicitud_gases')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_solicitudes');
    }
};
