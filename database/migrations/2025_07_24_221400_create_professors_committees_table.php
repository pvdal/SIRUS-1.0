<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->date('date');
            $table->boolean('status')->default(true);
            $table->string('professor_cpf', 11)->nullable();

            $table->foreign('professor_cpf')->references('professor_cpf')->on('professors');
            $table->foreignId('committee_id')->nullable()->constrained('committees');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('member_id')->nullable()->constrained('member_types');
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
