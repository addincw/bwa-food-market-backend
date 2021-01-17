<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $food = Food::inRandomOrder()->first();
        $user = User::first();

        Transaction::insert([
            [
                "food_id" => $food->id,
                "quantity" => 10,
                "total" => round($food->price * 10 * 1.1) + 50000,
                "status" => Transaction::STATUS_ON_DELIVERY,
                "user_id" => $user->id,
                "payment_url" => ''
            ],
            [
                "food_id" => $food->id,
                "quantity" => 7,
                "total" => round($food->price * 7 * 1.1) + 50000,
                "status" => Transaction::STATUS_DELIVERED,
                "user_id" => $user->id,
                "payment_url" => ''
            ],
            [
                "food_id" => $food->id,
                "quantity" => 5,
                "total" => round($food->price * 5 * 1.1) + 50000,
                "status" => Transaction::STATUS_CANCELLED,
                "user_id" => $user->id,
                "payment_url" => ''
            ]
        ]);
    }
}
