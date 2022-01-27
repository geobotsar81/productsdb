<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title=$this->faker->words(3, true);
        $price=$this->faker->randomFloat(2, 10, 10000);
        $reviews=$this->faker->numberBetween(0, 1000);
        $rating=$this->faker->randomFloat(2, 0, 10);
        $date_listed=$this->faker->dateTime($max = 'now');
       
        
        return [
            'title' => $title,
            'price' => $price,
            'reviews' => $reviews,
            'rating' => $rating,
            'date_listed' => $date_listed,
        ];
    }
}
