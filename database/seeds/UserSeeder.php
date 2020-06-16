<?php

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // $faker = new Faker();
        $user=\App\User::create([
            'name'=>'super_admin',
            'password'=>bcrypt('123456'),
            'email'=>'admin@pos.com',
        ]);

        $user->attachRole('super_admin');
    }
}
