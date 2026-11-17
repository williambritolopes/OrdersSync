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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('integration_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('external_id', 100);

            $table->string('status', 30)->default('pending');

            $table->char('currency', 3)->default('BRL');

            $table->decimal('total', 12, 2);

            $table->json('payload')->nullable();

            $table->timestamp('synced_at')->nullable();

            $table->timestamps();

            $table->unique(['integration_id', 'external_id']);

            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
