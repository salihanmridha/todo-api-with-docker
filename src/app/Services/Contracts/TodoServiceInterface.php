<?php

namespace App\Services\Contracts;

use Illuminate\Http\JsonResponse;

interface TodoServiceInterface
{
    /**
     * @param string $name
     * @param string|null $description
     * @return JsonResponse
     */
    public function createTodo(string $name, ?string $description): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function todoList(): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function showTodo(int $id): JsonResponse;

    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @return JsonResponse
     */
    public function updateTodo(int $id, string $name, ?string $description): JsonResponse;

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteTodo(int $id): JsonResponse;
}
