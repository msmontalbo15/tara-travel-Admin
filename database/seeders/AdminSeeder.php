<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Creates the first dashboard login. Reads from env so no real
     * credentials ever get hardcoded/committed — set ADMIN_SEED_EMAIL and
     * ADMIN_SEED_PASSWORD in .env before running, then feel free to
     * remove them again afterward.
     */
    public function run(): void
    {
        $email = env('ADMIN_SEED_EMAIL', 'admin@taratravel.ph');
        $password = env('ADMIN_SEED_PASSWORD');

        if (! $password) {
            $this->command->error('Set ADMIN_SEED_PASSWORD in .env before running this seeder.');

            return;
        }

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_SEED_NAME', 'Spencer'),
                'password' => Hash::make($password),
                'role' => 'owner',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("Admin account ready: {$email}");
    }
}
