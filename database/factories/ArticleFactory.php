<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * Class ArticleFactory
 *
 * @package   Database\Factories
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class ArticleFactory extends Factory
{

    /**
     * Property model
     *
     * @var string
     */
    protected $model = Article::class;


    /**
     * Function definition
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'author' => $this->faker->name(),
            'published_at' => $this->faker->date(),
            'source_id' => Source::exists() ? Source::all()->random()->id : Source::factory()->create()->id,
            'category_id' => Category::exists() ? Category::all()->random()->id : Category::factory()->create()->id,
        ];
    }//end definition()
}//end class
