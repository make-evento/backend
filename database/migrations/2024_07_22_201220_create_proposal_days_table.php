<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("proposal_days", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table
                ->foreignUlid("proposal_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->date("date");
            $table->string("start")->nullable();
            $table->string("end")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("proposal_days");
    }
};
