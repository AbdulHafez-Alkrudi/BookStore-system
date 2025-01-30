<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => \App\Models\Author::factory(),
            'category_id' => \App\Models\Category::factory(),
            'publisher_id' => \App\Models\Publisher::factory(),
            'title' => $this->faker->sentence(3),
            'price_for_sale' => $this->faker->randomFloat(2, 10, 100),
            'price_for_borrow' => $this->faker->randomFloat(2, 1, 20),
            'amount' => $this->faker->numberBetween(1, 100),
            'authorship_date' => $this->faker->date(),
            'available' => $this->faker->boolean(),
        ];
    }
}
