<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IAuthService;


/**
 * Class AuthController
 *
 * @package   App\Http\Controllers\Auth
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 20, 2024
 * @project   news-aggregator
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
