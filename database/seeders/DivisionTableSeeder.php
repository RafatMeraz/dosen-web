<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 3; $i++) {
            $name = $faker->unique()->words($nb = 2, $asText = true);

            $shop = new Division();
            $shop->name = ucwords($name);
            $shop->save();
        }
    }
}
