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
    //Tabela Professor_Banca
    public function up(): void
    {
        Schema::create('professors_committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->nullable()->constrained('professors')->nullOnDelete();
            $table->foreignId('committee_id')->nullable()->constrained('committees')->nullOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->foreignId('member_types_id')->nullable()->constrained('member_types')->nullOnDelete();
            $table->foreignId('events_id')->nullable()->default(true)->constrained('events')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->timestamps();

        });
        DB::statement('ALTER TABLE professors_committees ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE professors_committees ALTER COLUMN updated_at datetime2 NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professors_committees', function (Blueprint $table) {
            $table->dropForeign(['professor_cpf']);
        });
        Schema::dropIfExists('professors_committees');
    }
};
