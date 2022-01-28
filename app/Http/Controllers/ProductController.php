<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
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
    public function search(Request $request)
    {
        //Validate search fields
        $validator = Validator::make($request->all(), [
            'minPrice' => 'required',
            'maxPrice' => 'required',
            'minReviews' => 'required',
            'maxReviews' => 'required',
            'minDate' => 'required|date_format:d/m/Y',
            'maxDate' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        //Get products from repository
        $products=$this->productRepo->paginated($request);

        return $products;
    }
}
