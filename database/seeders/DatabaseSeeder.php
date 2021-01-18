<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Food Market',
            'address' => '',
            'city' => '',
            'house_number' => '',
            'phone_number' => '',
            'email' => 'admin@foodmarket.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN
        ]);

        $this->call([
            DummyUserSeeder::class,
            DummyFoodSeeder::class,
            DummyTransactionSeeder::class,
        ]);
    }
}
