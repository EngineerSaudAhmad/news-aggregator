<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\Contracts\IArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * Class ArticleController
 *
 * @package   App\Http\Controllers
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 *
 * @OA\Tag(
 *     name="Articles",
 *     description="API Endpoints of Articles"
 * )
 */
class ArticleController extends Controller
{

    /**
     * Property articleService
     *
     * @var IArticleService
     */
    private IArticleService $articleService;


    /**
     * ArticleController constructor.
     */
    public function __construct(IArticleService $articleService)
    {
        $this->articleService = $articleService;
    }//end __construct()


    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="List articles",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by date (Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by category ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="source",
     *         in="query",
     *         description="Filter by source ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page Number of records",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="title", type="string"),
     *                     @OA\Property(property="content", type="string"),
     *                     @OA\Property(property="author", type="string", nullable=true),
     *                     @OA\Property(property="published_at", type="string", format="date-time"),
     *                     @OA\Property(property="source_id", type="integer"),
     *                     @OA\Property(property="category_id", type="integer"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $articles = $this->articleService->findAll($request);

        return response()->json($articles);
    }//end index()


    /**
     * @OA\Get(
     *     path="/api/articles/{id}",
     *     summary="Get a specific article",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="author", type="string", nullable=true),
     *             @OA\Property(property="published_at", type="string", format="date-time"),
     *             @OA\Property(property="source_id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show(int $id): JsonResponse
    {
        $article = $this->articleService->findById($id);

        return response()->json($article);
    }//end show()
}//end class
