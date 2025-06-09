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
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('surname');
            $table->string('slug');
            $table->string('contact')->unique();
            $table->string('emergency_contact')->unique()->nullable();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('tenants');
    }
};
