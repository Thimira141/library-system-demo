<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => 'BOOK-' . now()->format('YmdHis') . '-' . fake()->unique()->randomLetter(),
            'book_title' => fake()->sentence(3),
            'book_author' => fake()->name(),
            'book_added' => now(),
            'book_remarks' => fake()->paragraph(),
            'book_cover_img' => 'default-book.jpg',
        ];
    }
}
