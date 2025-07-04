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
        Schema::create('rental_incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['rent', 'electricity', 'water', 'deposit', 'compensation', 'miscellaneous']);
            $table->text('description')->nullable();
            $table->float('amount', 2);
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('payment_date');
            $table->enum('mode_of_payment', ['mobile', 'bank', 'cash'])->nullable();
            $table->foreignUuid('tenant_id')->nullable()->references('id')->on('tenants')->onDelete('cascade');
            $table->string('receipt_number')->nullable();
            $table->enum('status', ['complete', 'partial', 'unpaid', 'waived']);
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
        Schema::dropIfExists('rental_incomes');
    }
};
