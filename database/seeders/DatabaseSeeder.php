<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;
use App\Models\User;
use App\Models\Member;
use App\Models\BookIssue;
use App\Models\BookReservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('book_reservations')->truncate();
        DB::table('book_issues')->truncate();
        DB::table('books')->truncate();
        DB::table('members')->truncate();
        DB::table('publishers')->truncate();
        DB::table('authors')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'Admin User 1',
            'email' => 'admin1@yopmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $memberUser = User::create([
            'name' => 'Member User 1',
            'email' => 'member1@yopmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        Member::create([
            'user_id' => $memberUser->id,
            'membership_no' => 'MEM-10001',
            'joining_date' => now()->subMonths(6)->format('Y-m-d'),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'status' => 'active',
        ]);

        $categories = collect();
        for ($i = 1; $i <= 8; $i++) {
            $categories->push(Category::create([
                'name' => fake()->unique()->randomElement(['Computer Science', 'Artificial Intelligence', 'Data Science', 'Mathematics', 'Literature', 'World History', 'Quantum Physics', 'Software Engineering']) . " " . rand(1, 100),
                'description' => fake()->sentence(10),
                'status' => 'active',
            ]));
        }

        $authors = collect();
        for ($i = 1; $i <= 20; $i++) {
            $authors->push(Author::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'biography' => fake()->paragraph(2),
                'status' => 'active',
            ]));
        }

        $publishers = collect();
        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->company() . ' Publishing';
            $publishers->push(Publisher::create([
                'name' => $name,
                'email' => fake()->unique()->companyEmail(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'website' => 'https://www.' . strtolower(str_replace([' ', ',', '.'], '', $name)) . '.com',
                'status' => 'active',
            ]));
        }

        for ($i = 1; $i <= 50; $i++) {
            $quantity = rand(5, 30);
            Book::create([
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
                'publisher_id' => $publishers->random()->id,
                'title' => fake()->unique()->sentence(3),
                'isbn' => '978' . rand(1000000000, 9999999999),
                'edition' => rand(1, 4) . 'th Edition',
                'language' => fake()->randomElement(['English', 'Spanish', 'French', 'German']),
                'price' => rand(15, 200) + 0.99,
                'quantity' => $quantity,
                'available_quantity' => $quantity,
                'publish_year' => rand(2000, 2026),
                'description' => fake()->paragraph(3),
                'cover_image' => 'https://picsum.photos/seed/book' . $i . '/300/450',
                'status' => 'available',
            ]);
        }

        for ($i = 2; $i <= 30; $i++) {
            $user = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'member',
            ]);

            Member::create([
                'user_id' => $user->id,
                'membership_no' => 'MEM-' . rand(10000, 99999),
                'joining_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'status' => 'active',
            ]);
        }

        $books = Book::all();
        $members = Member::all();

        for ($i = 1; $i <= 40; $i++) {
            $book = $books->random();

            if ($book->available_quantity > 0) {
                $book->decrement('available_quantity');
            }

            $issueDate = fake()->dateTimeBetween('-1 month', 'now');
            $returnDate = (clone $issueDate)->modify('+14 days');

            BookIssue::create([
                'book_id' => $book->id,
                'member_id' => $members->random()->id,
                'issue_date' => $issueDate->format('Y-m-d'),
                'return_date' => $returnDate->format('Y-m-d'),
                'actual_return_date' => null,
                'fine' => 0.00,
                'status' => 'issued',
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            BookReservation::create([
                'book_id' => $books->random()->id,
                'member_id' => $members->random()->id,
                'reserved_at' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
                'status' => fake()->randomElement(['pending', 'fulfilled', 'cancelled']),
            ]);
        }
    }
}