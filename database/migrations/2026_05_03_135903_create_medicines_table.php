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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
               $table->string('name');

        $table->string('brand_name')->nullable();

        $table->string('medicine_type')->nullable();

        $table->string('unit')->nullable();

        $table->decimal('purchase_price', 10, 2)->default(0);

        $table->decimal('selling_price', 10, 2)->default(0);

        $table->integer('stock')->default(0);

        $table->string('batch_number')->nullable();

        $table->date('manufacture_date')->nullable();

        $table->date('expiry_date')->nullable();

        $table->string('status')->default('active');

        $table->string('image')->nullable();

        $table->text('description')->nullable();

        $table->foreignId('category_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

        $table->foreignId('subcategory_id')
            ->nullable()
            ->constrained()
            ->onDelete('set null');

        $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
