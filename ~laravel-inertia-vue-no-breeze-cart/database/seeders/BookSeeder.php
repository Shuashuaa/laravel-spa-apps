<?php

namespace Database\Seeders;

use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => "Harry Potter and the Philosopher's Stone",
                'cover_img' => 'https://marketplace.canva.com/EAFaQMYuZbo/1/0/1003w/canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg',
                'price' => 10,
            ],
            [
                'title' => 'Atomic Habits',
                'cover_img' => 'https://marketplace.canva.com/EAFaQMYuZbo/1/0/1003w/canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg',
                'price' => 8.99,
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'cover_img' => 'https://marketplace.canva.com/EAFaQMYuZbo/1/0/1003w/canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg',
                'price' => 8.59,
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'cover_img' => 'https://marketplace.canva.com/EAFaQMYuZbo/1/0/1003w/canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg',
                'price' => 9.99,
            ],
            [
                'title' => 'Design Your Life',
                'cover_img' => 'https://marketplace.canva.com/EAFaQMYuZbo/1/0/1003w/canva-brown-rusty-mystery-novel-book-cover-hG1QhA7BiBU.jpg',
                'price' => 8.50,
            ],
        ];

        // Create multiple books using loop
        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}
