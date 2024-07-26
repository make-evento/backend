<?php

use App\DocumentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("suppliers", function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->string("razao_social");
            $table->string("nome_fantasia");
            $table->string("document_type");
            $table->string("document_number");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table
                ->foreignUlid("organization_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid("address_id")->constrained()->cascadeOnDelete();
            $table->unique(["document_number", "organization_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("suppliers");
    }
};
