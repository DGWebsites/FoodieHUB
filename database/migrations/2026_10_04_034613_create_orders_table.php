<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Delivery information
            $table->string('full_name');
            $table->string('phone');
            $table->text('address');
            $table->string('barangay');
            $table->string('city');
            $table->string('postal_code');
            $table->text('delivery_notes')->nullable();

            // Order totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            // Payment
            $table->string('payment_method');
            $table->string('payment_status')->default('Pending');

            // Order status
            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};