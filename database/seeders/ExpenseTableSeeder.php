<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 30; $i++) {
            $name = $faker->unique()->words($nb = 2, $asText = true);

            $shop = new Expense();
            $shop->user_id = User::where('role', 'user')->inRandomOrder()->first()->id;
            $shop->title = ucwords($name);
            $shop->remarks = ucfirst($faker->unique()->words($nb = 2, $asText = true));
            $shop->amount = rand(200,400);
            $shop->status = 'pending';
            $shop->save();
        }
    }
}
