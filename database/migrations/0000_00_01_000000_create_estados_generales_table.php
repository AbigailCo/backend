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
        Schema::create('estados_generales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('value');
            $table->string('label');
            $table->string('descripcion');
            $table->timestamps();
            $table->unique(['nombre', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_generales');
    }
};
