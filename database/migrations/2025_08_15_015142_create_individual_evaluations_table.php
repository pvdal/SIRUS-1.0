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
    public function up(): void
    {
        Schema::create('individual_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_committee_id')->nullable()->constrained('user_committees')->nullOnDelete();
            $table->string('ra', 13)->nullable();
            $table->foreignId('criteria_id')->nullable()->constrained('criteria')->nullOnDelete();
            $table->decimal('grade', 5, 2);
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('ra')->references('ra')->on('students')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual_evaluations');
    }
};
