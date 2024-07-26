<?php

use App\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("members", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("role")->default(Role::MEMBER->value);
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid("user_id")->constrained()->cascadeOnDelete();

            $table->unique(["organization_id", "user_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("members");
    }
};
