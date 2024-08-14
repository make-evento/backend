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
        Schema::create('todo_card_tasks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('todo_card_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_card_tasks');
    }
};
