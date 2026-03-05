<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Create default master admin: admin@gmail.com / admin@123
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Master Admin',
                'password' => 'admin@123',
                'role' => 'admin',
                'access_rules' => null, // full access
                'is_master' => true,
            ]
        );
    }
}
