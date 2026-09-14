<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Mobile fields (nullable for accessory)
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('imei')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('warranty_period')->nullable();
            $table->enum('reg_status', ['PTA', 'Non PTA'])->nullable();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('purchase_amount', 12, 2)->nullable();

            // Accessory fields (nullable for mobile)
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->decimal('sell_price', 12, 2)->nullable();

            // Shared
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
