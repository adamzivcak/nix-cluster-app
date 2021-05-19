<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'rpi-cluster',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin')
        ]);


    }
}
