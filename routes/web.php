<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Display the home page
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

//Routes related to movies CRUD for logged in user
Route::prefix('/my-movies')->middleware(['auth:sanctum', 'verified'])->name('movies.')->group(function () {
    Route::get('index', [MovieController::class,'index'])->name('index');
    Route::get('create', [MovieController::class,'create'])->name('create');
    Route::post('store', [MovieController::class,'store'])->name('store');
    Route::get('edit/{movie}', [MovieController::class,'edit'])->name('edit');
    Route::post('update/{movie}', [MovieController::class,'update'])->name('update');
    Route::post('destroy/{movie}', [MovieController::class,'destroy'])->name('destroy');
});

//Display a movie
Route::get('show/{movie}', [MovieController::class,'show'])->name('movies.show');

//Get paginated movies for the homepage
Route::post('movies-paginated', [MovieController::class,'paginated'])->name('movies.paginated');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
