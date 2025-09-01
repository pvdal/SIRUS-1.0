<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Tabela Avaliação_Banca
    public function up(): void
    {
        Schema::create('group_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->nullable()->constrained('criteria')->nullOnDelete();
            $table->foreignId('professor_committee_id')->nullable()->constrained('professors_committees')->nullOnDelete();
            $table->decimal('grade', 5, 2);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_evaluations');
    }
};
