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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('theme', 150);
            $table->string('file_path', 180)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE groups ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE groups ALTER COLUMN updated_at datetime2 NOT NULL');
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group');
    }
};
