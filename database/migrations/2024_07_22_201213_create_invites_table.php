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
        Schema::create("invites", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("email")->index();
            $table->string("role");
            $table
                ->foreignUlid("author_id")
                ->constrained("users")
                ->cascadeOnDelete();
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
        Schema::dropIfExists("invites");
    }
};
