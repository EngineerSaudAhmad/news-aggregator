<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * Class LoginController
 *
 * @package   App\Http\Controllers\Auth
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
class LoginController extends AuthController
{


    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate a user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="422", description="Invalid credentials"),
     *     @OA\Response(response="500", description="Someting went wrong.")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // call related service method for further processing.
            $response = $this->authService->login($request->email, $request->password);

            // Response with validation error.
            if (!empty($response['error'])) {
                unset($response['error']);
                return response()->json($response, $response['statusCode'] ?? 422);
            }

            return response()->json($response);
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json([
            'message' => 'Something went wrong while logging in.',
        ], 500);
    }//end login()


    /**
     * @OA\Get(
     *     path="/api/unauthorized-message",
     *     summary="Return unauthorized response for routes required authentication.",
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized message.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized"),
     *             @OA\Property(property="message", type="string", example="Authentication required."),
     *             @OA\Property(
     *                 property="login_uri",
     *                 type="array",
     *                 example="Login URI.",
     *                 @OA\Items(
     *                     @OA\Property(property="url", type="string", example="/api/login"),
     *                     @OA\Property(property="method", type="string", example="POST"),
     *                     @OA\Property(property="params", type="string", example="email, password")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function loginMessage(): JsonResponse
    {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Authentication required.',
            'login_uri' => [
                'url' => url('/api/login'),
                'method' => 'POST',
                'params' => 'email, password',
            ]
        ], 401);
    }//end login()
}//end class
