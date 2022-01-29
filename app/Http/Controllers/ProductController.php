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
     * Display a Product
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product):Response
    {
        return Inertia::render('Products/Show', ['product' => $product]);
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
     * Display the statistics page
     */
    public function statistics():Response
    {
        return Inertia::render('Statistics');
    }

    /**
     * Search and get the total statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatisticsTotal(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatisticsTotal($request);

        return $statistics;
    }

    /**
     * Search and get the days charts statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatisticsChartsDays(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatisticsChartsDays($request);

        return $statistics;
    }

    /**
     * Search and get the prices charts statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatisticsChartsPrices(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatisticsChartsPrices($request);

        return $statistics;
    }

    /**
     * Search and get the reviews charts statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatisticsChartsReviews(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatisticsChartsReviews($request);

        return $statistics;
    }

    /**
     * Search and get the ratings charts statistics data
     *
     * @param SearchFormRequest $request validates the search fields
     * @return array
     */
    public function getStatisticsChartsRatings(SearchFormRequest $request):array
    {
        //Get products from repository
        $statistics=$this->productRepo->getStatisticsChartsRatings($request);

        return $statistics;
    }
}
