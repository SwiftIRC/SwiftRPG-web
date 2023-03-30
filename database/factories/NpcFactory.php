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
    public function definition($last_name = null)
    {
        $genders = ["male", "female", "non-binary"];
        $gender = $genders[array_rand($genders)];

        $species_list = ["human", "dwarf", "elf"];
        $species = $species_list[array_rand($species_list)];

        $first = Name::inRandomOrder()->where(compact('species'))->where(compact('gender'))->first()->name;
        $last = (!empty($last_name) ? $last_name : Name::inRandomOrder()->where(compact('species'))->where('gender', null)->first()->name);

        return [
            'name' => $first . ' ' . $last,
        ];
    }
}
