<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
            'name' => 'System Administrator',
            // 'email' => 'admin@admin.com',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin')
        ]);

        User::create([
            'name' => 'System Monitor User',
            // 'email' => 'admin@admin.com',
            'username' => 'monitor',
            'role' => 'monitor',
            'password' => Hash::make('monitor')
        ]);

    }
}
