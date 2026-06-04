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

    $table->string('bill_number', 30)->unique();

    // SAFE FOREIGN KEY
    $table->foreignId('customer_id')
        ->constrained()
        ->onDelete('cascade');

    $table->string('customer_name', 100);
    $table->string('customer_phone', 15)->nullable();

    $table->enum('payment_mode', ['cash', 'card', 'upi'])->default('cash');

    $table->decimal('subtotal', 10, 2)->default(0);
    $table->decimal('tax_percentage', 5, 2)->default(0);
    $table->decimal('tax_amount', 10, 2)->default(0);
    $table->decimal('total_amount', 10, 2)->default(0);

    $table->enum('status', ['paid', 'unpaid'])->default('paid');

    $table->timestamps();
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
