<?php

namespace App\Http\Controllers;

use App\Models\Book;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular Last Month',
            'popular_last_6months' => 'Popular Last 6 Months',
            'highest_rated_last_month' => 'Highest Rated Last Month',
            'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
        ];

        $title = $request->input("title");
        $filter = $request->input("filter");


        // $books = Book::when($title, function($query) use($title){
        //     return $query->title($title);
        // })->get();


        //same query using arrow function

        $books = Book::when($title, fn($q, $title) => $q->title($title))->highestRated(new DateTime("-6 months"), null);

        $books = match($filter){
            "popular_last_month" => $books->popularLastMonth(),
            "popular_last_6months" => $books->popularLast6Month(),
            "highest_rated_last_month" => $books->highestRatedLastMonth(),
            "highest_rated_last_6months" => $books->highestRatedLast6Month(),
            default => $books->latest()
        };

        //$books = $books->get(); //using cache


        //using cache
        $cacheKey = "books:".$filter.":".$title;
        $books = Cache::remember($cacheKey, 3600, function () use($books) {
            return $books->get();
        });

        return view("books.index", ['books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

        $cacheKey = "book:".$book->id;


        $book = Cache::remember($cacheKey, 3600, fn()=>$book->load([
            'reviews'=> fn($query) => $query->latest()
            ]));

        return view('books.show', ['book'=>$book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
