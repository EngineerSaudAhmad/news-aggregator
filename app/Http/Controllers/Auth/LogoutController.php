<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class LogoutController
 *
 * @package   App\Http\Controllers\Auth
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 */
class LogoutController extends AuthController
{


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout the authenticated user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Logout successful"),
     *     @OA\Response(response="500", description="Something went wrong while logging out."),
     *     @OA\Response(response="401", description="Unauthorized message.")
     * )
     */
    public function logout(Request $request)
    {
        try {
            $response = $this->authService->logout($request);

            return response()->json($response);
        } catch (Throwable $e) {
            report($e);
        }

        return response()->json([
            'error' => 'Something went wrong while logging out.'
        ], 500);
    }//end logout()
}//end class
