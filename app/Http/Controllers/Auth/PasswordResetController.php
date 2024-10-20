<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;


/**
 * Class PasswordResetController
 *
 * @package   App\Http\Controllers\Auth
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
class PasswordResetController extends AuthController
{


    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Send a password reset link",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Password reset link sent"),
     *     @OA\Response(response="422", description="Validation error"),
     *     @OA\Response(response="500", description="Something went wrong while processing.")
     * )
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = $this->authService->sendResetLink($request->only('email'));

        if (!empty($response['sendStatus']) && $response['sendStatus'] == Password::RESET_LINK_SENT) {
            return response()->json(['message' => $response['message'] ?? 'Reset link sent to your email.']);
        }

        throw ValidationException::withMessages([
            'email' => [$response['message'] ?? 'Unable to send the reset link.'],
        ]);
    }//end forgotPassword()


    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     summary="Reset the user's password",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"token","email","password","password_confirmation"},
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="password_confirmation", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Password reset successful"),
     *     @OA\Response(response="422", description="Validation error"),
     *     @OA\Response(response="500", description="Something went wrong while processing.")
     * )
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = $this->authService->resetPassword($request->only('email', 'password', 'password_confirmation', 'token'));


        if (!empty($response['sendStatus']) && $response['sendStatus'] == Password::PASSWORD_RESET) {
            return response()->json(['message' => $response['message'] ?? 'Reset link sent to your email.']);
        }

        return response()->json([
            'email' => [$response['message'] ?? 'Reset link sent to your email.'],
        ]);
    }//end resetPassword()
}//end class
