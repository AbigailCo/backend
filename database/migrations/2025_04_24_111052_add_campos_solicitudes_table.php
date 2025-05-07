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
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->references('id')->on('categorias')->onDelete('set null');
            $table->string('fecha_inicio_reserva')->nullable();
            $table->string('fecha_fin_reserva')->nullable();
            $table->string('fecha_turno')->nullable();
            $table->string('hora_turno')->nullable();
            $table->string('nota')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
