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
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('contract_id')->constrained()->cascadeOnDelete();
            $table->decimal('cost_total', 10, 2);
            $table->string('payment_method');
            $table->string('payment_type');
            $table->integer('installments');
            $table->date('due_date');
            $table->decimal('installments_value', 10, 2);
            $table->unsignedSmallInteger('fine');
            $table->unsignedSmallInteger('interest');
            $table->text('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_payments');
    }
};
