<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('ra', 13)->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('semester');
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();;
            $table->timestamps();
        });
        // Altera as colunas timestamp para datetime2 no SQL Server
        DB::statement('ALTER TABLE students ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE students ALTER COLUMN updated_at datetime2 NOT NULL');
        DB::statement("ALTER TABLE students ADD CONSTRAINT chk_semester CHECK (semester BETWEEN 1 AND 10)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
