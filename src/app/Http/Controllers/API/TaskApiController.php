<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\DTO\TaskRequestDTO;
use App\Http\DTO\TaskUpdateRequestDTO;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    private TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/tasks",
     *      operationId="storeTask",
     *      tags={"Tasks"},
     *      summary="Store new task",
     *      description="Returns task data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResponseDTO")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="403 Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/HttpForbiddenResponseDTO")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function store(TaskRequest $request, TaskRequestDTO $requestDTO)
    {
        return $this->taskService->createTask($requestDTO->name, $requestDTO->todo_id);
    }

    /**
     * @OA\Get(
     *      path="/tasks/{id}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task information",
     *      description="Returns task data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskShowResponseDTO")
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
     *          response=403,
     *          description="403 Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/HttpForbiddenResponseDTO")
     *      ),
     * )
     */
    public function show(string $id)
    {
        return $this->taskService->showTask($id);
    }

    /**
     * @OA\Put(
     *      path="/tasks/{id}",
     *      operationId="updateTask",
     *      tags={"Tasks"},
     *      summary="Update existing task",
     *      description="Returns updated task data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequestDTO")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskShowResponseDTO")
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
     *      @OA\Response(
     *          response=403,
     *          description="403 Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/HttpForbiddenResponseDTO")
     *      ),
     * )
     */
    public function update(TaskUpdateRequest $request, int $id, TaskUpdateRequestDTO $requestDTO)
    {
        return $this->taskService->updateTask($id, $requestDTO->name);
    }

    /**
     * @OA\Delete(
     *      path="/tasks/{id}",
     *      operationId="deleteTask",
     *      tags={"Tasks"},
     *      summary="Delete existing task",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task id",
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
     *                  example="task deleted successfully",
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
    public function destroy(int $id)
    {
        return $this->taskService->deleteTask($id);
    }
}
