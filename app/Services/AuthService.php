<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\IAuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;


/**
 * Class AuthService
 *
 * @package   App\Services
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 19, 2024
 * @project   news-aggregator
 */
class AuthService extends BaseService implements IAuthService
{


    /**
     * Function __call
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        try {
            if (method_exists($this, $name)) {
                return call_user_func_array([$this, $name], $arguments);
            }
        } catch (Throwable $e) {
            report($e);
        }

        return [
            'error' => true,
            'status' => false,
            'message' => ['Something went wrong while processing.'],
            'statusCode' => 500,
        ];
    }//end __call()


    /**
     * @inheritdoc
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }//end register()


    /**
     * @inheritdoc
     */
    public function login(string $email, string $password): array
    {
        $user = User::firstWhere('email', $email);

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'error' => true,
                'email' => ['The provided credentials are incorrect.'],
            ];
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }//end login()


    /**
     * @inheritdoc
     */
    public function logout(Request $request): array
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logout successful',
        ];
    }//end logout()


    /**
     * @inheritdoc
     */
    public function sendResetLink(array $data): array
    {
        $status = Password::sendResetLink($data);

        return [
            'sendStatus' => $status,
            'message' => __($status),
        ];
    }//end sendResetLink()


    /**
     * @inheritdoc
     */
    public function resetPassword(array $data): array
    {
        $status = Password::reset(
            $data,
            function ($user) use ($data) {
                $user->forceFill([
                    'password' => Hash::make($data['password']),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return [
            'sendStatus' => $status,
            'message' => __($status),
        ];
    }//end resetPassword()
}//end class
