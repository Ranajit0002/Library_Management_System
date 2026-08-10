<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookIssueFactory extends Factory
{
    public function definition(): array
    {
        $issueDate = $this->faker->dateTimeBetween('-1 month', 'now');
        $returnDate = (clone $issueDate)->modify('+14 days');

        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'issue_date' => $issueDate->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'actual_return_date' => null,
            'fine' => 0.00,
            'status' => 'issued',
        ];
    }
}