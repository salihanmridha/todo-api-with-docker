<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface TaskServiceInterface
{
    /**
     * @param string $name
     * @param int $todoId
     * @return JsonResponse
     */
    public function createTask(string $name, int $todoId): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function showTask(int $id): JsonResponse;

    /**
     * @param int $id
     * @param string $name
     * @return JsonResponse
     */
    public function updateTask(int $id, string $name): JsonResponse;

    public function deleteTask(int $id): JsonResponse;

}
