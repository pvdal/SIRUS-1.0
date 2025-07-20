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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('shift', 20);
            $table->string('coordinator_cpf', 11)->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();

            $table->foreign('coordinator_cpf')->references('coordinator_cpf')->on('coordinators');
        });
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
