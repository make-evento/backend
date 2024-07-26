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
        Schema::create("proposal_customers", function (Blueprint $table) {
            $table
                ->foreignUlid("proposal_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignUlid("customer_id")
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(["proposal_id", "customer_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("proposal_customers");
    }
};
