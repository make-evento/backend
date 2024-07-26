<?php

use App\ProposalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("proposals", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("name");
            $table->unsignedInteger("people_count");
            $table->text("description")->nullable();
            $table->string("status");
            $table->string("duration")->nullable();
            $table
                ->foreignUlid("event_type_id")
                ->constrained("event_types")
                ->cascadeOnDelete();
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger("version");
            $table->timestamps();
        });

        Schema::table("proposals", function (Blueprint $table) {
            $table
                ->foreignUlid("parent_id")
                ->nullable()
                ->constrained("proposals")
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("proposals");
    }
};
