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
        Schema::create('vales_de_gas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('valor');
            $table->string('modificadoPor');
            $table->timestamp('fechaModificacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vales_de_gas');
    }
};
