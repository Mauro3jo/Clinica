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
        Schema::create('historiales_clinicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('primera_consulta')->nullable();
            $table->boolean('bajo_atencion_medica')->default(false);
            $table->boolean('enfermedad_grave')->default(false);
            $table->json('enfermedades')->nullable(); // JSON con enfermedades marcadas
            $table->boolean('medicacion')->default(false);
            $table->string('cual_medicacion')->nullable();
            $table->boolean('aspirinas')->default(false);
            $table->boolean('embarazo')->nullable(); // sólo si es mujer
            $table->boolean('problemas_dentales_previos')->default(false);
            $table->boolean('fuma')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales_clinicos');
    }
};
