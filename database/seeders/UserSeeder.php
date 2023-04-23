<?php

namespace Database\Seeders;

use App\Models\Tile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Dragon',
            'password' => '$2y$10$x6Y1U8RCssg.IqOUk7MQQOngUvYCmntyaxLP2UR1BiZUyzy5ov/rq',
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'TechSquid',
            'password' => '$2y$10$mOK0QZvQH8qpzD3wAUQSB.MXT1U22cAvtmdCnKjMUy/nK.DzNy/zS',
            'is_admin' => false,
        ]);
        User::factory()->create([
            'name' => 'Aaron',
            'password' => '$2y$10$eqmujVfQpDwzo9eJFJz45ecUNZHRTAUl2e5lG.QPWD5O14ysO36lK',
            'is_admin' => false,
        ]);
        User::factory()->create([
            'name' => 'Manderz',
            'password' => '$2y$10$ycyAk0j2j/tMwCuOJjIqwOXpXQVIxagC7ga5EhCn/yV4LtGG9AaKG',
            'is_admin' => false,
        ]);
        User::factory()->create([
            'name' => 'james',
            'password' => '$2y$10$OEUxB0aT1y3/rLNGrIxh8OdY2G9pHjEm/d.DrX.hd2VLCq6bI9vT2',
            'is_admin' => false,
        ]);
        User::factory()->create([
            'name' => 'Helix',
            'password' => '$2y$10$B.wzWPJMmvYvsXPqLbLa..qlA1Us.Z/eYiNz7aoDVAN5.IhdMHIxG',
            'is_admin' => false,
        ]);
        User::factory()->create([
            'name' => 'Shrimp',
            'password' => '$2y$10$pB5S4GHXxckQ8ujVu4H9..H1khSRmyu0q0wu7RFRn5cvReny52Yqa',
            'is_admin' => false,
        ]);

        // DB::table('personal_access_tokens')->insert([
        //     'tokenable_type' => 'App\Models\User',
        //     'tokenable_id' => 1,
        //     'name' => 'bot',
        //     'token' => '195a14888e8a8f8b47bdf6ce62decd5c845390039e223e7f59b48471933e3605',
        //     'abilities' => '["*"]',
        // ]);

        Tile::where('id', 1)->update(['discovered_by' => 1, 'discovered_at' => now()]);
    }
}
