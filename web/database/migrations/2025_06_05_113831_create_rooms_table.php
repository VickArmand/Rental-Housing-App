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
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->float('cost', 2);
            $table->foreignUuid('rental_id')->references('id')->on('rentals')->onDelete('cascade');
            $table->foreignUuid('tenant_id')->nullable()->references('id')->on('tenants')->onDelete('cascade');
            $table->boolean('is_occupied')->default(false);
            $table->timestamps();
            $table->foreignUuid('created_by')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('updated_by')->nullable()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
