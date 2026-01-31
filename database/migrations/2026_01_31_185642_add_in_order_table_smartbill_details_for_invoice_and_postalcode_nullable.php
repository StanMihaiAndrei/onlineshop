<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Câmpuri de facturare (billing) - pentru SmartBill
            $table->string('billing_name')->nullable()->after('smartbill_number');
            $table->string('billing_email')->nullable()->after('billing_name');
            $table->string('billing_phone')->nullable()->after('billing_email');
            $table->string('billing_address')->nullable()->after('billing_phone');
            $table->string('billing_city')->nullable()->after('billing_address');
            $table->string('billing_county')->nullable()->after('billing_city');
            $table->string('billing_postal_code')->nullable()->after('billing_county');
            $table->string('billing_country')->default('Romania')->after('billing_postal_code');
            
            // Câmpuri pentru firme
            $table->string('billing_company_name')->nullable()->after('billing_country')->comment('Nume firmă pentru persoane juridice');
            $table->string('billing_cif')->nullable()->after('billing_company_name')->comment('CIF pentru firme');
            $table->string('billing_reg_com')->nullable()->after('billing_cif')->comment('Nr. Registrul Comerțului');
        });
        
        // Modifică shipping_postal_code să nu mai fie obligatoriu
        DB::statement('ALTER TABLE orders MODIFY shipping_postal_code VARCHAR(255) NULL');
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_email',
                'billing_phone',
                'billing_address',
                'billing_city',
                'billing_county',
                'billing_postal_code',
                'billing_country',
                'billing_company_name',
                'billing_cif',
                'billing_reg_com',
            ]);
        });
        
        DB::statement('ALTER TABLE orders MODIFY shipping_postal_code VARCHAR(255) NOT NULL');
    }
};