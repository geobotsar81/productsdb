<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $appends = ['formated_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['title', 'price', 'reviews', 'rating', 'date_listed'];

    /**
     * Sort by Price
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeSortByPrice($query): Builder
    {
        return $query->orderBy('price', 'asc');
    }

    /**
     * Sort by date
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeSortByDate($query): Builder
    {
        return $query->orderBy('date_listed', 'desc');
    }

    /**
     * Sort by Reviews
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeSortByReviews($query): Builder
    {
        return $query->orderBy('reviews', 'desc');
    }

    /**
     * Generate a new attribute for a formated created date
     *
     * @return string
     */
    public function getFormatedDateAttribute(): string
    {
        $formated_date = \Carbon\Carbon::createFromTimeStamp(strtotime($this->date_listed))->diffForHumans();
        return $formated_date;
    }
}
