<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getAdmin = User::where('email', 'admin@example.com')->first();
        if (!$getAdmin) {
            $customer = new User();
            $customer->name = 'Mr Admin';
            $customer->email = 'admin@example.com';
            $customer->division_id = 1;
            $customer->role = 'admin';
            $customer->phone = '01700000000';
            $customer->password = Hash::make('12345678');
            $customer->designation = 'admin';
            $customer->block = 0;
            $customer->save();
        }

        $emails = ["user01@example.com", "user02@example.com", "user03@example.com"];

        foreach ($emails as $key => $email) {
            $getUser = User::where('email', $email)->first();
            if (!$getUser) {
                $customer = new User();
                $customer->name = 'Mr User ' . rand(1000, 9999);
                $customer->email = $email;
                $customer->division_id = rand(1,2);
                $customer->role = 'user';
                $customer->phone = '0170000000'.($key+1);
                $customer->password = Hash::make('12345678');
                $customer->designation = 'user';
                $customer->block = 0;
                $customer->save();
            }
        }
    }
}
