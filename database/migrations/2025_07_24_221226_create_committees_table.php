<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->boolean('status')->default(true);
            $table->string('coordinator_cpf', 11)->nullable();

            $table->foreign('coordinator_cpf')->references('coordinator_cpf')->on('coordinators');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE committees ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE committees ALTER COLUMN updated_at datetime2 NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropForeign(['coordinator_cpf']);
        });
        Schema::dropIfExists('committees');
    }
};
