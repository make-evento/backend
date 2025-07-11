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
        Schema::create("item_categories", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(["name", "organization_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("item_categories");
    }
};
