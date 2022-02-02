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

//Home page routes
Route::name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('home');
    Route::post('search-products', [ProductController::class, 'search'])->name('search');
    //Statistics routes
    Route::get('statistics', [ProductController::class, 'statistics'])->name('statistics');
    Route::post('get-statistics-total', [ProductController::class, 'getStatisticsTotal'])->name('get_statistics_total');
    Route::post('get-statistics-charts-days', [ProductController::class, 'getStatisticsChartsDays'])->name('get_statistics_charts_days');
    Route::post('get-statistics-charts-prices', [ProductController::class, 'getStatisticsChartsPrices'])->name('get_statistics_charts_prices');
    Route::post('get-statistics-charts-reviews', [ProductController::class, 'getStatisticsChartsReviews'])->name('get_statistics_charts_reviews');
    Route::post('get-statistics-charts-ratings', [ProductController::class, 'getStatisticsChartsRatings'])->name('get_statistics_charts_ratings');
    //Single product route
    Route::get('show/{product}', [ProductController::class, 'show'])->name('show');
});
