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
        Schema::create('historias', function (Blueprint $table) {
        $table->id();
        $table-> foreignId('id_profesional')->constrained("users")
        ->onUpdate('cascade')->onDelete('cascade');       
        $table->string('informacion_relevante');
        $table->time('hora');
        $table->date('fecha');
        $table->integer('consecutivo');
        $table->string('estado')->default("pendiente");
        $table->string('antecedentes')->nullable();
        $table->string('evaluacion')->nullable();
        $table->string('concepto')->nullable();
        $table->string('recomendaciones')->nullable();        
        $table->foreignId('id_paciente')->constrained("users")
        ->onUpdate('cascade')->onDelete('cascade');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
