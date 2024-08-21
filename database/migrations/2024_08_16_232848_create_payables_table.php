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
        Schema::create('payables', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table
                ->foreignUlid("supplier_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignUlid('todo_card_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->string('payment_type');
            $table->smallInteger('installments')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
