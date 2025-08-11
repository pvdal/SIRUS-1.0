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
            $table->foreignId('coordinators_id')->nullable()->constrained('coordinators')->nullOnDelete();
            $table->boolean('status')->default(true);
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
            $table->dropForeign(['coordinators_id']);
        });
        Schema::dropIfExists('committees');
    }
};
