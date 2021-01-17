<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jennie Kim',
            'address' => 'Jalan Jenderal Sudirman',
            'city' => 'Bandung',
            'house_number' => '1234',
            'phone_number' => '08123456789',
            'email' => 'jennie.kim@blackpink.com',
            'password' => Hash::make('password')
        ]);
    }
}
