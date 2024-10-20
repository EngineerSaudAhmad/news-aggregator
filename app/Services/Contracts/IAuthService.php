<?php

namespace App\Services\Contracts;


use Illuminate\Http\Request;

/**
 * Interface IAuthService
 *
 * @package   App\Services\Contracts
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 Techverx.com All rights reserved.
 * @since     Oct 19, 2024
 * @project   news-aggregator
 */
interface IAuthService extends IService
{


    /**
     * Function register
     *
     * @param array $data The data provided for registration.
     *
     * @return array
     */
    public function register(array $data): array;


    /**
     * Function login
     * It validates the user credentials and returns the response accordingly.
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    public function login(string $email, string $password): array;


    /**
     * Function logout
     * This expires the user provided token.
     *
     * @param Request $request
     *
     * @return array
     */
    public function logout(Request $request): array;


    /**
     * Function sendResetLink
     *
     * @param array $data
     *
     * @return array
     */
    public function sendResetLink(array $data): array;


    /**
     * Function resetPassword
     *
     * @param array $data
     *
     * @return array
     */
    public function resetPassword(array $data): array;
}//end interface
