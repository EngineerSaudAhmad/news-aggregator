<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Throwable;


/**
 * Class RegisterController
 *
 * @package   App\Http\Controllers\Auth
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
class RegisterController extends AuthController
{


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation error"),
     *     @OA\Response(response="500", description="Something went wrong while processing.")
     * )
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', PasswordRule::defaults()],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $response = $this->authService->register($request->all());

            // Response with validation error.
            if (!empty($response['error'])) {
                unset($response['error']);
                return response()->json($response, $response['statusCode'] ?? 422);
            }

            return response()->json($response ,201);
        } catch (Throwable $e) {
            report($e);
        }

        return response()->json([
            'message' => 'Something went wrong while processing.',
            'status' => false
        ], 500);
    }//end register()
}//end class
