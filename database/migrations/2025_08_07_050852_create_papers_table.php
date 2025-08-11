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
            $table->string('title', 150);
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->string('file_path', 180);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE papers ALTER COLUMN submitted_at datetime2');
        DB::statement('ALTER TABLE papers ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE papers ALTER COLUMN updated_at datetime2 NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
