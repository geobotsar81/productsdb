<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MovieRepository
{

    /**
     * Save a movie
     *
     * @param Array $data
     * @return void
     */
    public function store(array $data):void
    {
        Movie::create($data);
    }
    
    /**
     * Update a movie
     *
     * @param Array $data
     * @return void
     */
    public function update(array $data, Movie $movie):void
    {
        $movie->title=$data['title'];
        $movie->year=$data['year'];
        $movie->description=$data['description'];
        if ($data['image']) {
            $movie->image=$data['image'];
        }
        $movie->save();
    }


    /**
     * Get the moview for a specific user
     *
     * @param User $user
     * @return Collection
     */
    public function userMovies(User $user):Collection
    {
        return $user->movies()->get();
    }

    /**
     * Get a paginated list of movies
     *
     * @param String $search
     * @return LengthAwarePaginator
     */
    public function paginated(?String $search, Int $sort):LengthAwarePaginator
    {
        switch ($sort) {
            case 1:
                $movies=Movie::with(['user'])->where('title', 'LIKE', "%{$search}%")->sortByYear()->paginate(5);
                break;
            case 2:
                $movies=Movie::with(['user'])->where('title', 'LIKE', "%{$search}%")->sortByDate()->paginate(5);
                break;
            case 3:
                $movies=Movie::with(['user'])->where('title', 'LIKE', "%{$search}%")->sortByTitle()->paginate(5);
                break;
        }

        return $movies;
    }
}
