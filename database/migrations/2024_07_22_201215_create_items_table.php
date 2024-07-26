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
        Schema::create("items", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->string("details")->nullable();
            $table->boolean("display_details")->default(false);
            $table->boolean("is_todo")->default(false);
            $table
                ->foreignUlid("category_id")
                ->constrained("item_categories")
                ->cascadeOnDelete();
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(["name", "category_id", "organization_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("items");
    }
};
