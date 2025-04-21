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
        Schema::create('planes_tratamiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('fecha');
            $table->json('dientes_afectados')->nullable(); // Lista de dientes numerados
            $table->json('referencias')->nullable(); // Marcas de diagnóstico (caries, extracciones, etc.)
            $table->json('tratamientos_previos')->nullable();
            $table->json('tratamientos_propuestos')->nullable();
            $table->string('firma')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes_tratamiento');
    }
};
