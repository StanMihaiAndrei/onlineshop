<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        User::create([
            'name' => 'Andrei Stan',
            'email' => 'stanmihaiandrei@gmail.com',
            'password' => Hash::make('test1234'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    public function down(): void
    {
        User::where('email', 'stanmihaiandrei@gmail.com')->delete();
    }
};