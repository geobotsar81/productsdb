<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    /**
     * Get a paginated list of products
     *
     * @param String $search
     * @return LengthAwarePaginator
     */
    public function paginated(Request $request):Paginator
    {

        $minPrice=intval($request['minPrice']);
        $maxPrice=intval($request['maxPrice']);
        $minReviews=intval($request['minReviews']);
        $maxReviews=intval($request['maxReviews']);
        $sort=intval($request['sort']);

        $sortBy = match ($sort){
            1 => "price",
            2 => "date_listed",
            3 => "reviews",
        };

        $products=DB::table('products')
        ->where('price','>=',$minPrice)
        ->where('price','<=',$maxPrice)
        ->where('reviews','>=',$minReviews)
        ->where('reviews','<=',$maxReviews)
        ->orderBy($sortBy,'desc')
        ->simplePaginate(10);

        return $products;
    }
}
