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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->string('flat_number');
            $table->uuid('tenant_id'); // Building/tenant isolation
            $table->foreignId('house_owner_id')->constrained('users')->onDelete('cascade');
            $table->integer('floor')->nullable();
            $table->enum('status', ['vacant', 'occupied'])->default('vacant');
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index('house_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
