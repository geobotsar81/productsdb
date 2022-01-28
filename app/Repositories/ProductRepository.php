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

        switch ($sort) {
            case 1:
                $sortBy ="price";
                break;
            case 2:
                $sortBy ="date_listed";
                break;
            case 3:
                $sortBy ="reviews";
                break;
        }

        $products=DB::table('products')
        ->where('price', '>=', $minPrice)
        ->where('price', '<=', $maxPrice)
        ->where('reviews', '>=', $minReviews)
        ->where('reviews', '<=', $maxReviews)
        ->orderBy($sortBy, 'desc')
        ->simplePaginate(10);

        return $products;
    }
}
