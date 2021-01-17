<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DummyFoodSeeder extends Seeder
{
    private function _dummyPicturePath($faker)
    {
        $file = $faker->image('storage/app/public/food', 640, 480, 'food', true);
        return str_replace('storage/app/public/food\\', '/food/', $file);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Food::insert([
            [
                'picture_path' => $this->_dummyPicturePath($faker),
                'name' => "Sate Sayur Sultan",
                'description' => "Sate Sayur Sultan adalah menu sate vegan paling terkenal di Bandung. Sate ini dibuat dari berbagai macam bahan bermutu tinggi. Semua bahan ditanam dengan menggunakan teknologi masa kini sehingga memiliki nutrisi yang kaya.",
                'ingredients' => "Bawang Merah, Paprika, Bawang Bombay, Timun",
                'price' => 150000,
                'rate' => 4.2,
                'categories' => Food::CATEGORY_NEW_FOOD . "," . Food::CATEGORY_RECOMENDED . "," . Food::CATEGORY_POPULAR
            ],
            [
                'picture_path' => $this->_dummyPicturePath($faker),
                'name' => "Steak Daging Sapi Korea",
                'description' => "Daging sapi Korea adalah jenis sapi paling premium di Korea. Namun, untuk menikmatinya Anda tidak perlu jauh-jauh ke Korea Selatan. Steak Sapi Korea Oppa Bandung ini sudah terkenal di seluruh Indonesia dan sudah memiliki lebih dari 2 juta cabang.",
                'ingredients' => "Daging Sapi Korea, Garam, Lada Hitam",
                'price' => 750000,
                'rate' => 4.5,
                'categories' => Food::CATEGORY_NEW_FOOD . "," . Food::CATEGORY_POPULAR
            ],
            [
                'picture_path' => $this->_dummyPicturePath($faker),
                'name' => "Mexican Chopped Salad",
                'description' => "Salad ala mexico yang kaya akan serat dan vitamin. Seluruh bahan diambil dari Mexico sehingga akan memiliki cita rasa yang original.",
                'ingredients' => "Jagung, Selada, Tomat Ceri, Keju, Wortel",
                'price' => 105900,
                'rate' => 3.9,
                'categories' => Food::CATEGORY_RECOMENDED . "," . Food::CATEGORY_POPULAR
            ],
            [
                'picture_path' => $this->_dummyPicturePath($faker),
                'name' => "Sup Wortel Pedas",
                'description' => "Sup wortel pedas yang unik ini cocok banget buat kalian-kalian yang suka pedas namun ingin tetap sehat. Rasanya yang unik akan memanjakan lidah Anda.",
                'ingredients' => "Wortel, Seledri, Kacang Tanah, Labu, Garam, Gula",
                'price' => 60000,
                'rate' => 4.9,
                'categories' => Food::CATEGORY_NEW_FOOD
            ],
            [
                'picture_path' => $this->_dummyPicturePath($faker),
                'name' => "Korean Raw Beef Tartare",
                'description' => "Daging sapi Korea cincang yang disajikan mentah dan disiram saus spesial dengan toping kuning telur dan taburan biji wijen.",
                'ingredients' => "Daging Sapi Korea, Telur, Biji Wijen",
                'price' => 350000,
                'rate' => 3.4,
                'categories' => Food::CATEGORY_RECOMENDED
            ]
        ]);
    }
}
