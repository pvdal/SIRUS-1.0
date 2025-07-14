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
        Schema::create('coordinators', function (Blueprint $table) {
            $table->string('coordinator_cpf', 11)->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Altera as colunas timestamp para datetime2 no SQL Server
        DB::statement('ALTER TABLE coordinators ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE coordinators ALTER COLUMN updated_at datetime2 NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinators');
    }
};
