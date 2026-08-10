<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(5, 20);
        return [
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'edition' => '1st',
            'language' => 'English',
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $quantity,
            'available_quantity' => $quantity,
            'publish_year' => $this->faker->year(),
            'description' => $this->faker->paragraph(),
            'status' => 'available',
        ];
    }
}