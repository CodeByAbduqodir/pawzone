<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin PawZone',
                'email' => 'admin@pawzone.local',
                'role' => 'admin',
            ],
            [
                'name' => 'Owner Demo',
                'email' => 'owner@pawzone.local',
                'role' => 'owner',
            ],
            [
                'name' => 'Finder Demo',
                'email' => 'finder@pawzone.local',
                'role' => 'finder',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => 'password',
                    'role' => $user['role'],
                    'is_verified' => true,
                ]
            );
        }
    }
}
