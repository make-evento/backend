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
        Schema::create('installments', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->ulidMorphs('installmentable');
            $table->string('status')->default('pending');
            $table->smallInteger('installment');
            $table->smallInteger('total_installment');
            $table->string('payment_type');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->string('attachment')->nullable();
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
