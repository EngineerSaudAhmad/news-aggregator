<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IArticleService;
use App\Services\Contracts\IUserPreferenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;


/**
 * Class UserPreferenceController
 *
 * @package   App\Http\Controllers
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 *
 * @OA\Tag(
 *     name="User Preferences",
 *     description="API Endpoints of User Preferences"
 * )
 */
class UserPreferenceController extends Controller
{

    /**
     * Property userPreferenceService
     *
     * @var IUserPreferenceService
     */
    private IUserPreferenceService $userPreferenceService;


    /**
     * UserPreferenceController constructor.
     */
    public function __construct(IUserPreferenceService $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }//end __construct()


    /**
     * @OA\Get(
     *     path="/api/preferences",
     *     summary="List user preferences",
     *     tags={"User Preferences"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="source_id", type="integer"),
     *                 @OA\Property(property="category_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(
     *                     property="source",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="url", type="string"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     )
     *                 )
     *             )
     *         ),
     *         @OA\Response(response="500", description="Something went wrong while fetching user preferences.")
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Request $request)
    {
        try {
            $preferences = $this->userPreferenceService->getUserPreferences($request->user());
            return response()->json($preferences);
        } catch (Throwable $e) {
            report($e);
        }

        return response()->json([
            'message' => 'Something went wrong while fetching user preferences.',
        ], 500);
    }


    /**
     * @OA\Post(
     *     path="/api/preferences",
     *     summary="Create a new user preference",
     *     tags={"User Preferences"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"source_id", "category_id"},
     *             @OA\Property(property="source_id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="author", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Preference created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="source_id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="author", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_id' => 'required|exists:sources,id',
            'category_id' => 'required|exists:categories,id',
            'author' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $preference = $this->userPreferenceService->feedUserPreference(
            $request->user(),
            $request->only(['source_id', 'category_id', 'author']),
        );

        return response()->json($preference, 201);
    }//end store()


    /**
     * @OA\Get(
     *     path="/api/personalized-feed",
     *     summary="Get personalized news feed",
     *     tags={"User Preferences"},
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
     *                     @OA\Property(property="author", type="string"),
     *                     @OA\Property(property="user_id", type="integer"),
     *                     @OA\Property(property="source_id", type="integer"),
     *                     @OA\Property(property="category_id", type="integer"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     @OA\Property(
     *                         property="source",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="name", type="string"),
     *                             @OA\Property(property="url", type="string"),
     *                             @OA\Property(property="created_at", type="string", format="date-time"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time"),
     *                         )
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="name", type="string"),
     *                             @OA\Property(property="created_at", type="string", format="date-time"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time"),
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function personalizedFeed(Request $request)
    {
        $preferences = $this->userPreferenceService->getUserPreferences($request->user());


        $articles = resolve(IArticleService::class)->findByPreferences(
            $preferences->pluck('source_id')->toArray(),
            $preferences->pluck('category_id')->toArray(),
            $preferences->pluck('author')->toArray(),
        );

        return response()->json($articles);
    }//end personalizedFeed()
}//end class
