<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * Class SourceFactory
 *
 * @package   Database\Factories
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class SourceFactory extends Factory
{

    /**
     * Property model
     *
     * @var string
     */
    protected $model = Source::class;


    /**
     * Function definition
     *
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainName(),
            'url' => $this->faker->url(),
        ];
    }//end definition()
}//end class
