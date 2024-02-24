<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        return [

            'title' => fake()->title(),
            'description' => fake()->paragraph(),
            'price_in_cents_usd' => fake()->numberBetween(1,100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
