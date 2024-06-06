<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name('female'),
            'slug'=>$this->faker->slug(3),
            'description'=>$this->faker->text(100),
            'price'=>$this->faker->randomElement([1000.00,2000.00,3000.00,4000.00]),
        ];
    }
}
