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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150)->unique();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->string('file_path', 255)->nullable();
            $table->integer('year');
            $table->integer('semester');
            $table->enum('version', ['evaluation', 'corrected']);
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->unsignedInteger('project');
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
