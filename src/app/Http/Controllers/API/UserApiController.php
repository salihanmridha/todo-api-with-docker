<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\DTO\LoginRequestDTO;
use App\Http\DTO\RegistrationRequestDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="registerUser",
     *      tags={"Authentication"},
     *      summary="Register an user",
     *      description="Registering user and Returns json response with message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegistrationRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/RegistrationResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(ref="#/components/schemas/UnprocessableContentResponseDTO")
     *       ),
     * )
     */
    public function store(RegistrationRequest $request, RegistrationRequestDTO $requestDTO): JsonResponse
    {
        return $this->userService->registration($requestDTO->name, $requestDTO->email, $requestDTO->password);
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Login an user",
     *      description="Login an user and Returns json response",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LoginResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
                        property="status",
     *                  type="int",
     *                  example=401,
     *              ),
     *              @OA\Property(
                        property="success",
     *                  type="bool",
     *                  example=false,
     *              ),
     *              @OA\Property(
                        property="error",
     *                  type="string",
     *                  example="Email and Password doesn't match",
     *              ),
     *          )
     *       ),
     * )
     */
    public function login(LoginRequest $request, LoginRequestDTO $requestDTO)
    {
        return $this->userService->login($requestDTO->email, $requestDTO->password);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        request()->user()->currentAccessToken()->delete();
    }
}
