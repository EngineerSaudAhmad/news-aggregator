<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * Class CategoryFactory
 *
 * @package Database\Factories
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class CategoryFactory extends Factory
{

    /**
     * Property model
     *
     * @var string
     */
    protected $model = Category::class;


    /**
     * Function definition
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->streetName(),
        ];
    }//end definition()
}//end class
