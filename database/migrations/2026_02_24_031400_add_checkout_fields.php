<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add billing columns to orders table (if not exist)
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'full_name')) {
                $table->string('full_name')->nullable()->after('total');
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('full_name');
            }
            if (!Schema::hasColumn('orders', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('orders', 'post_code')) {
                $table->string('post_code')->nullable()->after('city');
            }
            if (!Schema::hasColumn('orders', 'province')) {
                $table->string('province')->nullable()->after('post_code');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->after('province');
            }
        });

        // Add proof_of_payment to payments table (if not exist)
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'proof_of_payment')) {
                $table->string('proof_of_payment')->nullable()->after('payment_reference');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'address', 'city', 'post_code', 'province', 'phone']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('proof_of_payment');
        });
    }
};
