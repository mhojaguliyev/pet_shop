<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'first_name' => 'Api',
                'last_name' => 'Admin',
                'is_admin' => true,
                'email' => 'admin@buckhill.co.uk',
                'password' => bcrypt('admin'),
                'address' => 'UK',
                'phone_number' => '123456',
                'is_marketing' => false,
            ],
            [
                'first_name' => 'Api',
                'last_name' => 'User',
                'is_admin' => false,
                'email' => 'user@buckhill.co.uk',
                'password' => bcrypt('user'),
                'address' => 'UK',
                'phone_number' => '123456',
                'is_marketing' => false,
            ],
        ];

        foreach ($userData as $userDatum) {
            User::create($userDatum);
        }
    }
}
