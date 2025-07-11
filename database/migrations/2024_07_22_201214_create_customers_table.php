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
        Schema::create("customers", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->string("email");
            $table->string("phone")->nullable();
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(["email", "organization_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("customers");
    }
};
