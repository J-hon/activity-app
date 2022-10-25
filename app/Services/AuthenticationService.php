<?php

namespace App\Services;

use App\Contracts\UserContract;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthenticationService
{

    public function __construct(protected UserContract $userRepository)
    {
    }

    public function login(array $data): array
    {
        try {
            $auth = Auth::attempt($data);
            if ($auth) {
                $user = Auth::user();

                return [
                    'status'  => true,
                    'message' => 'Login successful',
                    'code'    => 200,
                    'data'    => [
                        'user'       => new UserResource($user),
                        'auth_token' => $user->createToken($user->email)->plainTextToken
                    ]
                ];
            }

            return [
                'status'  => false,
                'message' => 'Incorrect login credentials! Please try again',
                'code'    => 401,
                'data'    => []
            ];
        }
        catch (Throwable $th) {
            report($th);
            return [
                'status'  => false,
                'message' => 'An error occurred. Please try again shortly',
                'code'    => 400,
                'data'    => []
            ];
        }
    }

    public function register(array $data): array
    {
        try {
            $unHashedPassword = $data['password'];
            $data['password'] = Hash::make($data['password']);

            $user = $this->userRepository->create($data);

            return $this->login([
                'email'    => $user->email,
                'password' => $unHashedPassword
            ]);
        }
        catch (Throwable $th) {
            report($th);
            return [
                'status'  => false,
                'message' => 'An error occurred. Please try again shortly',
                'code'    => 400,
                'data'    => []
            ];
        }
    }

}
