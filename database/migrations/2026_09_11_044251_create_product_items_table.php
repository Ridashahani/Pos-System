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
            $table->string('brand');
            $table->string('model');
            $table->string('imei')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('warranty_period')->nullable();
            $table->enum('reg_status', ['PTA', 'Non PTA']);
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->decimal('purchase_amount', 12, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
