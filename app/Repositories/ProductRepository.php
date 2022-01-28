<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    /**
     * Get a paginated list of products
     *
     * @param String $search
     * @return LengthAwarePaginator
     */
    public function paginated(?string $search, int $sort):LengthAwarePaginator
    {
        switch ($sort) {
            case 1:
                $products=Product::where('title', 'LIKE', "%{$search}%")->sortByPrice()->paginate(10);
                break;
            case 2:
                $products=Product::where('title', 'LIKE', "%{$search}%")->sortByDate()->paginate(10);
                break;
            case 3:
                $products=Product::where('title', 'LIKE', "%{$search}%")->sortByReviews()->paginate(10);
                break;
        }

        return $products;
    }
}
