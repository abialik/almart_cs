<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique();

            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();

            // petugas yang handle order
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // billing info
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('province')->nullable();
            $table->string('phone')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
