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
        Schema::create("proposal_taxes", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table
                ->foreignUlid("proposal_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->string("name");
            $table->decimal("value", 5, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("proposal_taxes");
    }
};
