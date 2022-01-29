<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class ProductRepository
{
    public function __construct()
    {
        $this->cacheDuration=config('cache.stores.redis.duration');
    }

    /**
     * Get a paginated list of products
     *
     * @param String $search
     * @return Paginator
     */
    public function getProducts(Request $request):Paginator
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];
        $sort=$request['sort'];
        $sortDirection="desc";

        switch ($sort) {
            case 1:
                $sortBy ="price";
                $sortDirection="desc";
                break;
            case 2:
                $sortBy ="price";
                $sortDirection="asc";
                break;
            case 3:
                $sortBy ="date_listed";
                $sortDirection="desc";
                break;
            case 4:
                $sortBy ="date_listed";
                $sortDirection="asc";
                break;
            case 5:
                $sortBy ="reviews";
                $sortDirection="desc";
                break;
            case 6:
                $sortBy ="reviews";
                $sortDirection="asc";
                break;
        }

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);

        $products=DB::table('products')
        ->where('price', '>=', $minPrice)
        ->where('price', '<=', $maxPrice)
        ->where('reviews', '>=', $minReviews)
        ->where('reviews', '<=', $maxReviews)
        ->whereBetween('date_listed', [$startDate, $endDate])
        ->orderBy($sortBy, $sortDirection)
        ->simplePaginate(10);

        return $products;
    }

    /**
     * Get statistics about the products
     *
     * @param Request $request
     * @return array
     */
    public function getStatisticsTotal(Request $request):array
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);
        
       
        //Total products count
        $start = microtime(true);
        $totalProducts=DB::table('products')
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->where('reviews', '>=', $minReviews)
            ->where('reviews', '<=', $maxReviews)
            ->whereBetween('date_listed', [$startDate, $endDate])
            ->count();
        $totalProductsTime = microtime(true) - $start;


        $statistics=[
            'totalProducts' => number_format($totalProducts),
            'totalProductsTime' => $totalProductsTime,
        ];

        return $statistics;
    }

    /**
     * Get days statistics about the products
     *
     * @param Request $request
     * @return array
     */
    public function getStatisticsChartsDays(Request $request):array
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);
        
       
        //Products number per week day listed
        $start = microtime(true);
        $daysQuery=DB::table('products')
            ->select(DB::raw('DAYNAME(date_listed) as dataLabel'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->where('reviews', '>=', $minReviews)
            ->where('reviews', '<=', $maxReviews)
            ->whereBetween('date_listed', [$startDate, $endDate]);

        $daysSum=DB::table('productsWeekDays')
            ->select(DB::RAW('COUNT(dataLabel) as dataCount'), 'dataLabel')
            ->fromSub($daysQuery, 'productsWeekDays')
            ->groupBy('dataLabel')
            ->orderBy('dataLabel', 'asc')
            ->get();
        $totalDaysTime = microtime(true) - $start;


        $statistics=[
            'days' => $daysSum,
            'totalDaysTime' => $totalDaysTime,
        ];

        return $statistics;
    }

    /**
     * Get prices statistics about the products
     *
     * @param Request $request
     * @return array
     */
    public function getStatisticsChartsPrices(Request $request):array
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);
        
        //Products groubed by price
        $start = microtime(true);
        $priceQuery=DB::table('products')
            ->select(DB::raw('(floor((price + 100) / 100) * 100) as dataLabel'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->where('reviews', '>=', $minReviews)
            ->where('reviews', '<=', $maxReviews)
            ->whereBetween('date_listed', [$startDate, $endDate]);

        $pricesSum=DB::table('productsRouncedPrices')
            ->select(DB::RAW('COUNT(dataLabel) as dataCount'), 'dataLabel')
            ->fromSub($priceQuery, 'productsRouncedPrices')
            ->groupBy('dataLabel')
            ->orderBy('dataLabel', 'asc')
            ->get();
        $totalPricesTime = microtime(true) - $start;
       
        $statistics=[
            'prices' => $pricesSum,
            'totalPricesTime' => $totalPricesTime,
        ];

        return $statistics;
    }

    /**
     * Get ratings statistics about the products
     *
     * @param Request $request
     * @return array
     */
    public function getStatisticsChartsRatings(Request $request):array
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);
       
        //Products groubed by ratings
        $start = microtime(true);
        $ratingQuery=DB::table('products')
            ->select(DB::raw('(floor(rating)) as dataLabel'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->where('reviews', '>=', $minReviews)
            ->where('reviews', '<=', $maxReviews)
            ->whereBetween('date_listed', [$startDate, $endDate]);

        $ratingsSum=DB::table('productsRatings')
            ->select(DB::RAW('COUNT(dataLabel) as dataCount'), 'dataLabel')
            ->fromSub($ratingQuery, 'productsRatings')
            ->groupBy('dataLabel')
            ->orderBy('dataLabel', 'asc')
            ->get();
        $totalRatingsTime = microtime(true) - $start;

        $statistics=[
            'ratings' => $ratingsSum,
            'totalRatingsTime' => $totalRatingsTime,
        ];

        return $statistics;
    }

    /**
     * Get reviews statistics about the products
     *
     * @param Request $request
     * @return array
     */
    public function getStatisticsChartsReviews(Request $request):array
    {
        $minPrice=$request['minPrice'];
        $maxPrice=$request['maxPrice'];
        $minReviews=$request['minReviews'];
        $maxReviews=$request['maxReviews'];
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];

        $startDate = Carbon::createFromFormat('d/m/Y', $minDate);
        $endDate = Carbon::createFromFormat('d/m/Y', $maxDate);
        
        //Products groubed by reviews
        $start = microtime(true);
        $reviewsQuery=DB::table('products')
            ->select(DB::raw('(floor((reviews + 100) / 100) * 100) as dataLabel'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->where('reviews', '>=', $minReviews)
            ->where('reviews', '<=', $maxReviews)
            ->whereBetween('date_listed', [$startDate, $endDate]);

        $reviewsSum=DB::table('productsReviews')
            ->select(DB::RAW('COUNT(dataLabel) as dataCount'), 'dataLabel')
            ->fromSub($reviewsQuery, 'productsReviews')
            ->groupBy('dataLabel')
            ->orderBy('dataLabel', 'asc')
            ->get();
        $totalReviewsTime = microtime(true) - $start;

        $statistics=[
            'reviews' => $reviewsSum,
            'totalReviewsTime' => $totalReviewsTime
        ];

        return $statistics;
    }
}
