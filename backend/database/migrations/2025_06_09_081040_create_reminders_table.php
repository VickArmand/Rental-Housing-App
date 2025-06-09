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
        Schema::create('reminders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->timestamp('remind_at');
            $table->timestamp('completed_at')->nullable();
            $table->enum('type', ['daily', 'once', 'custom', 'yearly', 'monthly', 'weekly']);
            $table->integer('repeat_interval')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'completed', 'dismissed', 'sent'])->default('pending');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('reminders');
    }
};
