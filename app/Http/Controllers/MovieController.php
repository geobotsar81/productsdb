<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MovieRepository;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MovieController extends Controller
{
    protected $movieRepo;

    /**
     * Inject the movie repository class into the controller
     *
     * @param MovieRepository $movieRepo
     */
    public function __construct(MovieRepository $movieRepo)
    {
        $this->movieRepo=$movieRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $userMovies= $this->movieRepo->userMovies($user);
        return Inertia::render('Movies/Index', ['userMovies' => $userMovies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Movies/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovieRequest $request)
    {
        $user = Auth::user();
        $image = $request->file('image')->storePublicly('movies', 'public');

        $data = $request->validated();

        $data['user_id']=$user->id;
        $data['image']=$image;

        $this->movieRepo->store($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return Inertia::render('Movies/Show', ['movie' => $movie]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $user = Auth::user();

        if ($user->cannot('update', $movie)) {
            abort(403);
        }

        return Inertia::render('Movies/Edit', ['movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $user = Auth::user();

        if ($user->cannot('update', $movie)) {
            abort(403);
        }

        $data = $request->validated();

        //Check if request contains a new image
        if ($request->file('image')) {
            $image = $request->file('image')->storePublicly('movies', 'public');
            $data['image']=$image;
        }

       
        $data['user_id']=$user->id;

        $this->movieRepo->update($data, $movie);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $user = Auth::user();
        
        if ($user->cannot('delete', $movie)) {
            abort(403);
        }

        $movie->delete();
        return redirect()->back();
        ;
    }


    /**
     * Get a paginated list of all the movies
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function paginated(Request $request):LengthAwarePaginator
    {
        $search=$request['search'];
        $sort=$request['sort'];

        $movies=$this->movieRepo->paginated($search, $sort);
        return $movies;
    }
}
