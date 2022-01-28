<?php

namespace App\Repositories;

use Carbon\Carbon;
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
        $minDate=$request['minDate'];
        $maxDate=$request['maxDate'];
        $sort=intval($request['sort']);
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
}
