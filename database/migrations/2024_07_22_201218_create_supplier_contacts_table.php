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
        Schema::create("supplier_contacts", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table
                ->foreignUlid("supplier_id")
                ->constrained("suppliers")
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("supplier_contacts");
    }
};
