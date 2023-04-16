<?php

namespace Database\Seeders;

use App\Models\Reward;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thieving = Skill::firstWhere('name', 'thieving');
        Reward::create()->skills()->attach($thieving->id, ['value' => 5]);
    }
}
