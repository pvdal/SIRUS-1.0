<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Tabela Critérios
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('weight', 4, 2)->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            });

        DB::statement('ALTER TABLE criteria ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE criteria ALTER COLUMN updated_at datetime2 NOT NULL');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
