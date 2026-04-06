<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('shipping_type', ['delivery', 'pickup'])->default('delivery')->after('order_code');
            $table->string('pickup_code')->nullable()->unique()->after('shipping_type');
            $table->text('pickup_note')->nullable()->after('pickup_code');
        });

        // Update enum status to include ready_for_pickup
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'delivering', 'ready_for_pickup', 'delivered', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_type', 'pickup_code', 'pickup_note']);
        });

        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'delivering', 'delivered', 'cancelled') DEFAULT 'pending'");
    }
};
