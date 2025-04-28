<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('apellido');
            $table->string('nombre');
            $table->string('dni')->unique();
            $table->enum('sexo', ['masculino', 'femenino', 'otro']);
            $table->integer('edad')->nullable(); // 👈 Edad nueva
            $table->date('fecha_nacimiento')->nullable();
            $table->string('obra_social')->nullable();
            $table->string('codigo_obra_social')->nullable(); // 👈 Código Obra Social nuevo
            $table->string('afiliado_nro')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('titular')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('localidad')->nullable(); // 👈 Localidad nueva
            $table->string('telefono')->nullable();
            $table->string('servicio')->nullable(); // Presta servicio en
            $table->date('fecha_primera_consulta')->nullable(); // 👈 Fecha 1ra consulta nueva
            $table->text('observaciones')->nullable(); // 👈 Observaciones nuevas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
