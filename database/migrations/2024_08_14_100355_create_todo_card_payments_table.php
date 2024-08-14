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
        Schema::create('todo_card_payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('todo_card_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('supplier_id')->constrained()->cascadeOnDelete();
            $table->date('closed_at');
            $table->string('payment_type');
            $table->smallInteger('installment');
            $table->date('first_payment_at');
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_card_payments');
    }
};
