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
        Schema::create("addresses", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("street");
            $table->string("number");
            $table->string("complement")->nullable();
            $table->string("neighborhood")->nullable();
            $table->string("city");
            $table->string("state");
            $table->string("zip_code");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("addresses");
    }
};
