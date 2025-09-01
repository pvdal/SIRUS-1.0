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
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('committee_id')->nullable()->constrained('committees')->nullOnDelete();
            $table->foreignId('member_type_id')->nullable()->constrained('member_types')->nullOnDelete();
            $table->boolean('state')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professors_committees', function (Blueprint $table) {
            $table->dropForeign(['professor_id']);
            $table->dropForeign(['committee_id']);
            $table->dropForeign(['member_type_id']);
        });
        Schema::dropIfExists('professors_committees');
    }
};
