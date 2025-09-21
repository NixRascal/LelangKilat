<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'icon_path' => $this->faker->randomElement([
                'icons/electronics.svg',
                'icons/fashion.svg',
                'icons/home.svg',
                'icons/hobby.svg',
            ]),
        ];
    }
}
