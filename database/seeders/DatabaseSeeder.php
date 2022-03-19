<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $gender = $faker->randomElement(['male', 'female']);
        foreach (range(1, 30000) as $index) {
            DB::table('customers')->insert([
                'name' => $faker->name($gender),
                'username' => $faker->username . $index,
                'password' => bcrypt($faker->password),
                // 'phone' => $faker->phoneNumber,
                // 'dob' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
