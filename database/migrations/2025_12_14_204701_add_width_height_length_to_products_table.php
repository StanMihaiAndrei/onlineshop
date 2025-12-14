<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('width', 8, 2)->nullable()->after('stock');
            $table->decimal('height', 8, 2)->nullable()->after('width');
            $table->decimal('length', 8, 2)->nullable()->after('height');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['width', 'height', 'length']);
        });
    }
};