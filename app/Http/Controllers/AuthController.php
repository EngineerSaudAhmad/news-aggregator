<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IAuthService;


/**
 * Class AuthController
 *
 * @package   App\Http\Controllers
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of User Authentication."
 * )
 */
abstract class AuthController extends Controller
{
    /**
     * Property authService
     *
     * @var IAuthService
     */
    protected IAuthService $authService;


    /**
     * LoginController constructor.
     */
    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }//end __construct()
}//end class
