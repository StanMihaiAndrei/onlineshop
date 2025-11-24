<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed']); // percentage = procent, fixed = suma fixă
            $table->decimal('value', 10, 2); // 10% sau 50 RON
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('usage_limit')->nullable(); // de câte ori poate fi folosit (optional)
            $table->integer('usage_count')->default(0); // de câte ori a fost folosit
            $table->decimal('minimum_order_amount', 10, 2)->nullable(); // comandă minimă (optional)
            $table->timestamps();
        });

        // Adăugăm coloana coupon_id în tabelul orders
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('coupon_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn(['coupon_id', 'discount_amount']);
        });
        
        Schema::dropIfExists('coupons');
    }
};