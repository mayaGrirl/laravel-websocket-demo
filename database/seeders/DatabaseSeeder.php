<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();


        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
