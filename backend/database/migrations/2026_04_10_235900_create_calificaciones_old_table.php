<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones_old', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';

            $table->increments('id');
            $table->string('marcatemporal', 50)->nullable();
            $table->string('Email', 200)->nullable();
            $table->string('Matricula', 250)->nullable();
            $table->string('Nombre', 250)->nullable();
            $table->string('APaterno', 250)->nullable();
            $table->string('AMaterno', 250)->nullable();
            $table->string('Periodo', 255)->nullable();
            $table->string('Tetramestre', 255)->nullable();
            $table->string('Nivel', 255)->nullable();
            $table->string('Asignatura', 255)->nullable();
            $table->string('CalificacionFinal', 10)->nullable();
            $table->string('Catedratico', 255)->nullable();
            $table->integer('id_estudiante')->nullable();

            $table->unique(['Matricula', 'Asignatura'], 'calificaciones_old_matricula_asignatura_unique');
            $table->index('id_estudiante', 'calificaciones_old_id_estudiante_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones_old');
    }
};