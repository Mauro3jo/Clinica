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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('apellido');
            $table->string('nombre');
            $table->string('dni')->unique();
            $table->enum('sexo', ['masculino', 'femenino', 'otro']);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('obra_social')->nullable();
            $table->string('afiliado_nro')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('titular')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('servicio')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
