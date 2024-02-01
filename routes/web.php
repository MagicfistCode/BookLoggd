<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReadingListController;
use App\Http\Controllers\UserController;  
use App\Http\Controllers\BadgeController; 
use App\Http\Controllers\PostController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//user routes
//user - books
route::get('/books/display', [BookController::class, 'display'])->name('book.display');
route::get('/books/{book}/show', [BookController::class, 'show'])->name('book.show');
route::post('/books/display', [ReadingListController::class, 'store'])->name('readinglist.store');
route::get('/books/readinglist', [ReadingListController::class, 'index'])->name('book.readinglist');
route::delete('books/readinglist/{list_id}/destroy', [ReadingListController::class, 'destroy'])->name('readinglist.destroy');
route::get('/books/search', [BookController::class, 'search'])->name('books.search');
//user - users
route::get('/users/{user}', [UserController::class, 'show'])->name('user.profile');
route::get('/users/{user}/readinglist', [ReadingListController::class, 'show'])->name('readinglist.show');
//user - badges
route::get('/badges/display', [BadgeController::class, 'display'])->name('badge.display');
//user - books
route::get('/authors/{author}/show', [AuthorController::class, 'show'])->name('author.show');
//user - posts
route::post('/users', [PostController::class, 'store'])->name('post.store');
route::get('/post-dashboard', [PostController::class, 'display'])->name('post.display');


//admin routes
//admin book routes - crud
route::get('/book', [BookController::class, 'index'])->name('book.index');
route::get('/book/create', [BookController::class, 'create'])->name('book.create');
route::post('/book', [BookController::class, 'store'])->name('book.store');
route::get('/book/{book}/edit', [BookController::class, 'edit'])->name('book.edit');
route::put('/book/{book}/update', [BookController::class, 'update'])->name('book.update');
route::put('/book/{book}/updateCover', [BookController::class, 'updateCover'])->name('book.updateCover');
route::delete('/book/{book}/destroy', [BookController::class, 'destroy'])->name('book.destroy');
route::get('/book/admSearch', [BookController::class, 'admSearch'])->name('book.admSearch');

//admin author routes -crud
route::get('/author', [AuthorController::class, 'index'])->name('author.index');
route::get('/author/create', [AuthorController::class, 'create'])->name('author.create');
route::post('/author/store', [AuthorController::class, 'store'])->name('author.store');
route::get('/author/{author}/edit', [AuthorController::class, 'edit'])->name('author.edit');
route::put('/author/{author}/update', [AuthorController::class, 'update'])->name('author.update');
route::put('/author/{author}/updateCover', [AuthorController::class, 'updateCover'])->name('author.updateCover');
route::delete('/author/{author}/destroy', [AuthorController::class, 'destroy'])->name('author.destroy');
route::get('/author/admSearch', [AuthorController::class, 'admSearch'])->name('author.admSearch');

//admin badge routes -crud
route::get('/badge', [BadgeController::class, 'index'])->name('badge.index');
route::get('/badge/create', [BadgeController::class, 'create'])->name('badge.create');
route::post('/badge/store', [BadgeController::class, 'store'])->name('badge.store');
route::get('/badge/{badge}/edit', [BadgeController::class, 'edit'])->name('badge.edit');
route::put('/badge/{badge}/update', [BadgeController::class, 'update'])->name('badge.update');
route::put('/badge/{badge}/updateCover', [BadgeController::class, 'updateCover'])->name('badge.updateCover');
route::delete('/badge/{badge}/destroy', [BadgeController::class, 'destroy'])->name('badge.destroy');
route::get('/badge/admSearch', [BadgeController::class, 'admSearch'])->name('badge.admSearch');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
