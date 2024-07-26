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
        Schema::create('todo_card_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid("item_id")->constrained()->cascadeOnDelete();
            $table->foreignUlid('todo_card_id')->constrained()->cascadeOnDelete();

            $table->string('description')->nullable();

            $table->unsignedInteger("customer_quantity");
            $table->unsignedTinyInteger("customer_days");
            $table->decimal("customer_cost_per_unit", 10, 2);
            $table->decimal("customer_cost_total", 10, 2);

            $table->unsignedInteger("supplier_quantity");
            $table->unsignedTinyInteger("supplier_days");
            $table->decimal("supplier_cost_per_unit", 10, 2);
            $table->decimal("supplier_cost_total", 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_card_items');
    }
};
