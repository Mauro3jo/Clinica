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
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('fecha');
            $table->string('codigo')->nullable();
            $table->string('pieza_dental')->nullable();
            $table->string('ubicacion_lesion')->nullable();
            $table->decimal('arancel', 8, 2)->nullable();
            $table->decimal('pago', 8, 2)->nullable();
            $table->decimal('debe', 8, 2)->nullable();
            $table->decimal('saldo', 8, 2)->nullable();
            $table->string('conducta_rx')->nullable();
            $table->string('trabajo_realizado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
