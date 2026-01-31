<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('smartbill_series')->nullable()->after('sameday_tracking_history');
            $table->string('smartbill_number')->nullable()->after('smartbill_series');
            $table->string('shipping_county')->nullable()->after('shipping_city');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['smartbill_series', 'smartbill_number', 'shipping_county']);
        });
    }
};