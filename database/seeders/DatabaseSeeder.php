<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * The super admin is upserted from SUPER_ADMIN_EMAIL / SUPER_ADMIN_PASSWORD,
     * so credentials never live in source control. Safe to run on every deploy.
     */
    public function run(): void
    {
        $email = env('SUPER_ADMIN_EMAIL');
        $password = env('SUPER_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('SUPER_ADMIN_EMAIL / SUPER_ADMIN_PASSWORD not set; skipping super admin seed.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => $password,
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}
