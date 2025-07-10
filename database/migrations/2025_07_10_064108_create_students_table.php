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
        Schema::create('students', function (Blueprint $table) {
            $table->string('ra', 11)->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('semester');
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->tinyInteger('access_level');
            $table->boolean('state',)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
