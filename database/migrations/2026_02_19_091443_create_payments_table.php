<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            $table->enum('method', [
                'transfer',
                'ewallet',
                'qris',
                'cod'
            ])->default('transfer');

            $table->enum('status', [
                'unpaid',
                'paid',
                'failed'
            ])->default('unpaid');

            $table->string('payment_reference')->nullable();
            $table->string('proof_of_payment')->nullable(); // path file bukti pembayaran

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
