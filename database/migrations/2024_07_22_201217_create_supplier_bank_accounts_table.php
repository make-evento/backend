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
        Schema::create("supplier_bank_accounts", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("bank_name")->nullable();
            $table->unsignedSmallInteger("bank_code")->nullable();
            $table->string("agency")->nullable();
            $table->string("account")->nullable();
            $table->string("account_dv")->nullable();
            $table->string("account_type")->nullable();
            $table->string("pix_key")->nullable();
            $table->string("pix_key_type")->nullable();
            $table
                ->foreignUlid("supplier_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("supplier_bank_accounts");
    }
};
