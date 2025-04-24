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
        Schema::table('servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->references('id')->on('categorias')->onDelete('set null');
            $table->string('duracion')->nullable(); 
            $table->string('ubicacion')->nullable();
            $table->json('horarios')->nullable(); 
        });
        Schema::create('servicio_dia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('dia_semana_id')->constrained('dias_semana')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'duracion', 'ubicacion', 'horarios']);
        });
    
        Schema::dropIfExists('servicio_dia');
    }
};
