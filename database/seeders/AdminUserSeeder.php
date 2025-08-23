<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'petshop@pakam.com'],
            [
                'name' => 'Petshop Pakam',
                'email' => 'petshop@pakam.com',
                'password' => Hash::make('dunia12345'),
                'role' => 'admin',
            ]
        );

        // Create sample regular user
        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User Demo',
                'email' => 'user@user.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        echo "Default users created:\n";
        echo "Admin: petshop@pakam.com / dunia12345\n";
        echo "User: user@user.com / user123\n";
    }
}
