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
    //Tabela Banca
    public function up(): void
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('coordinator_id')->nullable()->constrained('coordinators')->nullOnDelete();
            $table->foreignId('rubric_id')->nullable()->constrained('rubrics')->nullOnDelete();
            $table->foreignId('paper_id')->nullable()->constrained('papers')->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropForeign(['coordinator_id']);
            $table->dropForeign(['rubric_id']);
            $table->dropForeign(['event_id']);
        });
        Schema::dropIfExists('committees');
    }
};
