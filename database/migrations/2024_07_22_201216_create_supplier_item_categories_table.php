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
        Schema::create("supplier_item_categories", function (Blueprint $table) {
            $table
                ->foreignUlid("supplier_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignUlid("item_category_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->unique(["supplier_id", "item_category_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("supplier_item_categories");
    }
};
