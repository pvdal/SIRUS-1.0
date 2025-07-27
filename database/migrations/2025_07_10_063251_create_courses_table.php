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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('shift', 20);
            $table->foreignId('coordinator_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('state')->default(true);
            $table->timestamps();


        });

        DB::statement('ALTER TABLE courses ALTER COLUMN created_at datetime2 NOT NULL');
        DB::statement('ALTER TABLE courses ALTER COLUMN updated_at datetime2 NOT NULL');
        DB::statement("ALTER TABLE courses ADD CONSTRAINT chk_shift CHECK (shift IN ('morning', 'afternoon', 'night'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['coordinator_cpf']);
        });

        Schema::dropIfExists('courses');
    }
};
