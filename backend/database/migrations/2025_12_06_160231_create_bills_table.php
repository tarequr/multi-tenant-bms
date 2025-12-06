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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained('flats')->onDelete('cascade');
            $table->uuid('tenant_id');
            $table->foreignId('bill_category_id')->constrained('bill_categories')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('month'); // YYYY-MM-01 format
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();

            $table->index(['tenant_id', 'month']);
            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
