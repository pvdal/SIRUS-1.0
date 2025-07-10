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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('title',100);
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->string('color',45)->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE events ALTER COLUMN start datetime2');
        DB::statement('ALTER TABLE events ALTER COLUMN [end] datetime2 NULL');
        DB::statement('ALTER TABLE events ALTER COLUMN created_at datetime2');
        DB::statement('ALTER TABLE events ALTER COLUMN updated_at datetime2');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
