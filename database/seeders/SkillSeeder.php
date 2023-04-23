<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::factory()->createMany([
            ['name' => 'thieving'],
            ['name' => 'fishing'],
            ['name' => 'mining'],
            ['name' => 'woodcutting'],
            ['name' => 'firemaking'],
            ['name' => 'cooking'],
            ['name' => 'smithing'],
            ['name' => 'fletching'],
            ['name' => 'crafting'],
            ['name' => 'herblore'],
            ['name' => 'agility'],
            ['name' => 'farming'],
            ['name' => 'hunter'],
        ]);
    }
}
