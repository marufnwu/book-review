<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them willp
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource("books", BookController::class);

Route::resource("books.reviews", ReviewController::class)
    ->scoped(["review"=>"book"])->only(["create", "store"]);

