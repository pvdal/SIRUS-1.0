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
        Schema::create('rubric_axis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rubric_id')->constrained('rubrics')->onDelete('cascade');
            $table->foreignId('axis_id')->constrained('axes')->onDelete('cascade');
            $table->integer('weight');// Peso do Eixo na rubrica
            $table->enum('type', ['individual', 'in group']);// Tipo de avaliação do eixo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('rubric_axis');
    }
};
