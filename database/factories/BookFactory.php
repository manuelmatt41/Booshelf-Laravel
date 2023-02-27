<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Genre;
use App\Models\User;
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
            'user_id' => User::factory(),
            'isbn' => $this->faker->random_int(1000000000000, 9999999999999),
            'genre_id' => Genre::factory(),
            'title' => $this->faker->word(),
            'author_id' => Author::factory(),
            'synopsis' => $this->faker->words(),
            'pages' => $this->faker->random_int(1, 100),
            'finished' => $this->faker->boolean()
        ];
    }
}
