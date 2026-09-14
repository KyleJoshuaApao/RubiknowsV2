<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Upsert superadmin — safe to run on every deploy.
        // Uses updateOrCreate so it never fails on duplicate email.
        User::updateOrCreate(
            ['email' => 'Kylejoshua878@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('Ellah878#'),
                'role'     => 'Super Admin',
            ]
        );
    }
}
