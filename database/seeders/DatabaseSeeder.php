<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function ($book){
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
            ->good()
            ->for($book)
            ->create();
        });

        Book::factory(33)->create()->each(function ($book){
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
            ->average()
            ->for($book)
            ->create();
        });

        Book::factory(34)->create()->each(function ($book){
            $numReviews = random_int(5, 30);
            Review::factory($numReviews)
            ->bad()
            ->for($book)
            ->create();
        });
    }
}
