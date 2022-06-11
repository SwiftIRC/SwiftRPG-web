<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Dragon',
            'password' => '$2y$10$x6Y1U8RCssg.IqOUk7MQQOngUvYCmntyaxLP2UR1BiZUyzy5ov/rq',
            'is_admin' => true,
        ]);
        DB::table('users')->insert([
            'name' => 'TechSquid',
            'password' => '$2y$10$mOK0QZvQH8qpzD3wAUQSB.MXT1U22cAvtmdCnKjMUy/nK.DzNy/zS',
            'is_admin' => false,
        ]);
        DB::table('users')->insert([
            'name' => 'Aaron',
            'password' => '$2y$10$eqmujVfQpDwzo9eJFJz45ecUNZHRTAUl2e5lG.QPWD5O14ysO36lK',
            'is_admin' => false,
        ]);

        // DB::table('personal_access_tokens')->insert([
        //     'tokenable_type' => 'App\Models\User',
        //     'tokenable_id' => 1,
        //     'name' => 'bot',
        //     'token' => '195a14888e8a8f8b47bdf6ce62decd5c845390039e223e7f59b48471933e3605',
        //     'abilities' => '["*"]',
        // ]);
    }
}
