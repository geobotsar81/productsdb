<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    protected $productRepo;

    /**
     * Inject the product repository class into the controller
     *
     * @param ProductRepository $productRepo
     */
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo=$productRepo;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Inertia::render('Products/Show', ['product' => $product]);
    }


    /**
     * Get a paginated list of all the products
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function paginated(Request $request):LengthAwarePaginator
    {
        $search=$request['search'];
        $sort=$request['sort'];

        $products=$this->productRepo->paginated($search, $sort);
        return $products;
    }
}
