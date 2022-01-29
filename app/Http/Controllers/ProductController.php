<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Repositories\ProductRepository;
use App\Http\Requests\SearchFormRequest;

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
     * Display the home page
     */
    public function index():Response
    {
        return Inertia::render('Welcome');
    }

    /**
     * Search and get a paginated list of all the products
     *
     * @param SearchFormRequest $request validates the search fields
     * @return Paginator
     */
    public function search(SearchFormRequest $request):Paginator
    {
        //Get products from repository
        $products=$this->productRepo->getProducts($request);

        return $products;
    }


    /**
     * Display the home page
     */
    public function statistics():Response
    {
        return Inertia::render('Statistics');
    }

    /**
     * Search and get the statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatistcs(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatistics($request);

        return $statistics;
    }

    /**
     * Display a Product
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product):Response
    {
        return Inertia::render('Products/Show', ['product' => $product]);
    }
}
