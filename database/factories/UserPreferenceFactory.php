<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * Class UserPreferenceFactory
 *
 * @package Database\Factories
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class UserPreferenceFactory extends Factory
{

    /**
     * Property model
     *
     * @var string
     */
    protected $model = UserPreference::class;


    /**
     * Function definition
     *
     * @return array|mixed[]
     */
    public function definition(): array
    {
        return [
            'user_id' => User::exists() ? User::all()->random()->id : User::factory()->create()->id,
            'source_id' => Source::exists() ? Source::all()->random()->id : Source::factory()->create()->id,
            'category_id' => Category::exists() ? Category::all()->random()->id : Category::factory()->create()->id,
            'author' => $this->faker->name(),
        ];
    }//end definition()
}//end class
