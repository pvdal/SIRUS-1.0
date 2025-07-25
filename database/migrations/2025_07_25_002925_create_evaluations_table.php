<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Tabela Avaliação_Banca
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaluations_id');
            $table->decimal('grade', 5, 2);
            $table->string('comment');
            $table->foreignId('criteria_id')->nullable()->constrained('criteria');
            $table->foreignId('professor_committee_id')->nullable()->constrained('professors_committees');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE evaluations ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE evaluations ALTER COLUMN updated_at datetime2 NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
