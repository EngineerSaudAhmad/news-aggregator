<?php

namespace App\Services;

use App\Models\Article;
use App\Services\Contracts\IArticleService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Throwable;


/**
 * Class ArticleService
 *
 * @package   App\Services
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
class ArticleService implements IArticleService
{

    /**
     * Property model
     *
     * @var Article
     */
    private Article $model;


    /**
     * ArticleService constructor.
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }//end __construct()


    /**
     * @inheritdoc
     */
    public function findAll(Request $request, bool $isPaginated = true): Collection|LengthAwarePaginator|array
    {
        $articles = [];
        try {
            $query = $this->model::query();

            // Apply filters
            if ($request->has('keyword')) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('content', 'like', '%' . $request->keyword . '%');
            }

            if ($request->has('date')) {
                $query->whereDate('published_at', $request->date);
            }

            if ($request->has('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->has('source')) {
                $query->where('source_id', $request->source);
            }

            // Paginate results
            if ($isPaginated) {
                $articles = $query->paginate(10);
            } else {
                $articles = $query->get();
            }
        } catch (Throwable $e) {
            report($e);
        }

        return $articles;
    }//end findAll()


    /**
     * @inheritdoc
     */
    public function findById(int $id): ?array
    {
        try {
            $article = $this->model->find($id);
            return $article->toArray();
        } catch (Throwable $e) {
            report($e);
        }

        return null;
    }//end findById()
}//end class
