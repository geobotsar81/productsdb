<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

//Search products in homepage
Route::post('search-products', [ProductController::class,'search'])->name('products.search');
Route::get('statistics', [ProductController::class,'show'])->name('products.statistics');


//Display a product
Route::get('show/{product}', [ProductController::class,'show'])->name('products.show');
