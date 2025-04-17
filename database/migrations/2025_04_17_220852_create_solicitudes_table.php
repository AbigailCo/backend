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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('proveedor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
            $table->text('mensaje_opcional')->nullable();
            $table->foreignId('estado_general_id')->default(4)->constrained('estados_generales');
            $table->string('fecha_solicitud')->useCurrent();
            $table->string('fecha_respuesta')->nullable();
            $table->timestamps();
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
