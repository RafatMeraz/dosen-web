<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 5; $i++) {
            $shop_name = $faker->unique()->words($nb = 2, $asText = true);

            $shop = new Shop();
            $shop->division_id = rand(1,2);
            $shop->name = ucwords($shop_name);
            $shop->address = $faker->address();
            $shop->save();

            for ($j = 1; $j <= 40; $j++) {
                $shop_name = $faker->unique()->words($nb = 2, $asText = true);

                $visit = new Visit();
                $visit->user_id = User::where('role', 'user')->inRandomOrder()->first()->id;
                $visit->shop_id = $shop->id;
                $visit->remarks = ucfirst($faker->unique()->words($nb = 2, $asText = true));
                $visit->save();


            }
        }
    }
}
