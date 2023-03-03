<?php

namespace App\Services;

use App\Services\Contracts\UserServiceInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function registration(string $name, string $email, string $password): JsonResponse
    {
        $this->user->create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
        ]);

        return response()->json([
            "status" => Response::HTTP_CREATED,
            "success" => true,
            "message" => "User created successfully",
        ]);
    }

    /**
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function login(string $email, string $password): JsonResponse
    {
        $user = $this->user->findOneBy([
            "email" => $email,
        ]);

        if ($user && Hash::check($password, $user->password)) {

            $accessToken = $user->createToken('token-name', ["auth"])->plainTextToken;

            return response()->json([
                "status" => Response::HTTP_OK,
                "success" => true,
                "message" => "Login successfully!",
                "access_token" => $accessToken,
                "data" => $user
            ]);
        }

        return response()->json([
            "status" => Response::HTTP_UNAUTHORIZED,
            "success" => false,
            'error' => "Email and Password doesn't match",
        ]);

    }

}
