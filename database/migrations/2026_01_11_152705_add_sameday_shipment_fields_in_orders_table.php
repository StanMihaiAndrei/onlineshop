<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Sameday delivery fields
            $table->enum('delivery_type', ['home', 'locker'])->default('home')->after('shipping_country');
            $table->integer('sameday_county_id')->nullable()->after('delivery_type');
            $table->integer('sameday_city_id')->nullable()->after('sameday_county_id');
            $table->integer('sameday_locker_id')->nullable()->after('sameday_city_id')->comment('ID Easybox/PUDO');
            $table->string('sameday_locker_name')->nullable()->after('sameday_locker_id');
            
            // AWB fields
            $table->string('sameday_awb_number')->nullable()->after('sameday_locker_name')->unique();
            $table->decimal('sameday_awb_cost', 10, 2)->nullable()->after('sameday_awb_number');
            $table->string('sameday_awb_pdf')->nullable()->after('sameday_awb_cost');
            $table->enum('sameday_awb_status', ['not_created', 'created', 'in_transit', 'delivered', 'returned'])->default('not_created')->after('sameday_awb_pdf');
            $table->text('sameday_tracking_history')->nullable()->after('sameday_awb_status');
            
            // Person type (0 = fizică, 1 = juridică)
            $table->boolean('is_company')->default(false)->after('shipping_country');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_type',
                'sameday_county_id',
                'sameday_city_id',
                'sameday_locker_id',
                'sameday_locker_name',
                'sameday_awb_number',
                'sameday_awb_cost',
                'sameday_awb_pdf',
                'sameday_awb_status',
                'sameday_tracking_history',
                'is_company',
            ]);
        });
    }
};