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
        Schema::create("proposal_items", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table
                ->foreignUlid("proposal_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid("item_id")->constrained()->cascadeOnDelete();
            $table->unsignedInteger("quantity");
            $table->text("description")->nullable();
            $table->unsignedTinyInteger("days");
            $table->decimal("cost_per_unit", 10, 2);
            $table->decimal("cost_total", 10, 2);

            $table->unique(["proposal_id", "item_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("proposal_items");
    }
};
