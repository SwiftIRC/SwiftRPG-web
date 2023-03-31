<?php

namespace Database\Factories;

use App\Models\Name;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Npc>
 */
class NpcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $genders = ["male", "female", "non-binary"];
        $gender = $genders[array_rand($genders)];

        $species_list = ["human", "dwarf", "elf"];
        $species = $species_list[array_rand($species_list)];

        $first = Name::inRandomOrder()->where(compact('species'))->where(compact('gender'))->first()->name;
        $last = Name::inRandomOrder()->where(compact('species'))->whereNull('gender')->first()->name;

        $base_level = rand(0, 50);
        $max_level = rand($base_level, 99);

        return [
            'first_name' => $first,
            'last_name' => $last,
            'species' => $species,
            'gender' => $gender,
            'thieving' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'fishing' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'mining' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'woodcutting' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'firemaking' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'cooking' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'smithing' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'fletching' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'crafting' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'herblore' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'agility' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'farming' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
            'hunter' => level_to_xp(rand($base_level, $max_level)) + rand(0, 1000),
        ];
    }
}
