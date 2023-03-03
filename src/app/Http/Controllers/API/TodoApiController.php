<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\DTO\TodoRequestDTO;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Contracts\TodoServiceInterface;

class TodoApiController extends Controller
{
    private TodoServiceInterface $todoService;

    public function __construct(TodoServiceInterface $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * @OA\Get(
     *      path="/todos",
     *      operationId="getTodoList",
     *      tags={"Todo"},
     *      summary="Get list of todos",
     *      description="Returns list of todos",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TodoResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     )
     */
    public function index(): JsonResponse
    {
        return $this->todoService->todoList();
    }

    /**
     * @OA\Post(
     *      path="/todos",
     *      operationId="storetodo",
     *      tags={"Todo"},
     *      summary="Store new todo",
     *      description="Returns todo data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TodoStoreResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(ref="#/components/schemas/UnprocessableContentResponseDTO")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function store(TodoRequest $request, TodoRequestDTO $requestDTO): JsonResponse
    {
        return $this->todoService->createTodo($requestDTO->name, $requestDTO->description);
    }

    /**
     * @OA\Get(
     *      path="/todos/{id}",
     *      operationId="getTodoById",
     *      tags={"Todo"},
     *      summary="Get todo information",
     *      description="Returns todo data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TodoShowResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="404 not found",
     *          @OA\JsonContent(ref="#/components/schemas/HttpNotFoundResponseDTO")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function show(int $id)
    {
        return $this->todoService->showTodo($id);
    }

    /**
     * @OA\Put(
     *      path="/todos/{id}",
     *      operationId="updateTodo",
     *      tags={"Todo"},
     *      summary="Update existing todo",
     *      description="Returns updated todo data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TodoShowResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="404 not found",
     *          @OA\JsonContent(ref="#/components/schemas/HttpNotFoundResponseDTO")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(ref="#/components/schemas/UnprocessableContentResponseDTO")
     *      ),
     * )
     */
    public function update(TodoRequest $request, int $id, TodoRequestDTO $requestDTO)
    {
        return $this->todoService->updateTodo($id, $requestDTO->name, $requestDTO->description);
    }

    /**
     * @OA\Delete(
     *      path="/todos/{id}",
     *      operationId="deleteTodo",
     *      tags={"Todo"},
     *      summary="Delete existing todo",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="int",
     *                  example=202,
     *              ),
     *              @OA\Property(
     *                  property="success",
     *                  type="bool",
     *                  example=true,
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="todo deleted successfully",
     *              ),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="403 Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/HttpForbiddenResponseDTO")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="404 not found",
     *          @OA\JsonContent(ref="#/components/schemas/HttpNotFoundResponseDTO")
     *      ),
     * )
     */
    public function destroy(string $id)
    {
        return $this->todoService->deleteTodo($id);
    }
}
