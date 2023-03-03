<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface UserServiceInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function registration(string $name, string $email, string $password): JsonResponse;

    /**
     * @param string $email
     * @param string $password
     * @return JsonResponse
     */
    public function login(string $email, string $password): JsonResponse;
}
