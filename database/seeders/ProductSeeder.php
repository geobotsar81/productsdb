<?php

namespace Database\Seeders;

use Faker\Generator;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container;

class ProductSeeder extends Seeder
{

    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Product::truncate();
        
        $no_of_rows = 1000000;
        $range=range(1, $no_of_rows);
        $chunksize=2000;

        foreach (array_chunk($range, $chunksize) as $chunk) {
            $productData = array();
            foreach ($chunk as $i) {
                $productData[] = array(
                'title'=>$this->faker->text(10),
                'price'=>$this->faker->randomFloat(2, 10, 10000),
                'reviews'=>$this->faker->numberBetween(0, 1000),
                'rating'=>$this->faker->randomFloat(2, 0, 10),
                'date_listed'=>$this->faker->dateTimeBetween('-2 years', 'now')
         );
            }
            //Product::insert($productData);
            DB::table('products')->insert($productData);
        }
    }
}
