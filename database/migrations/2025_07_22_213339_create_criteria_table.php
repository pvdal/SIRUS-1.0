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
    //Tabela Critérios
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->text('unsatisfactory')->nullable();
            $table->decimal('weight_i', 4, 2)->default(0);
            $table->text('satisfactory')->nullable();
            $table->decimal('weight_s', 4, 2)->default(0);
            $table->text('good')->nullable();
            $table->decimal('weight_g', 4, 2)->default(0);
            $table->text('excellent')->nullable();
            $table->decimal('weight_e', 4, 2)->default(0);
            $table->tinyInteger('criteria_type')->default(1);
            $table->boolean('state')->default(true);
            $table->timestamps();
            });

        // Adicionar CHECK para tipo_criterio = 1 ou 2 e max_peso entre 0 e 10
        DB::statement("ALTER TABLE criteria ADD CONSTRAINT chk_criteria_type CHECK (criteria_type IN (1, 2))");
        DB::statement("ALTER TABLE criteria ADD CONSTRAINT chk_weight_i CHECK (weight_i BETWEEN 0 AND 10)");
        DB::statement("ALTER TABLE criteria ADD CONSTRAINT chk_weight_s CHECK (weight_s BETWEEN 0 AND 10)");
        DB::statement("ALTER TABLE criteria ADD CONSTRAINT chk_weight_g CHECK (weight_g BETWEEN 0 AND 10)");
        DB::statement("ALTER TABLE criteria ADD CONSTRAINT chk_weight_e CHECK (weight_e BETWEEN 0 AND 10)");

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover constraints antes de dropar a tabela
        DB::statement('ALTER TABLE criteria DROP CONSTRAINT chk_criteria_type');
        DB::statement('ALTER TABLE criteria DROP CONSTRAINT chk_weight_i');
        DB::statement('ALTER TABLE criteria DROP CONSTRAINT chk_weight_s');
        DB::statement('ALTER TABLE criteria DROP CONSTRAINT chk_weight_g');
        DB::statement('ALTER TABLE criteria DROP CONSTRAINT chk_weight_e');

        Schema::dropIfExists('criteria');
    }
};
