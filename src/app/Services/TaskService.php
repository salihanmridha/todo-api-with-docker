<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Repositories\Contracts\TodoRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskService implements TaskServiceInterface
{
    private TaskRepositoryInterface $task;
    private TodoRepositoryInterface $todo;

    public function __construct(
        TaskRepositoryInterface $task,
        TodoRepositoryInterface $todo
    )
    {
        $this->task = $task;
        $this->todo = $todo;
    }

    /**
     * @param string $name
     * @param int $todoId
     * @return JsonResponse
     */
    public function createTask(string $name, int $todoId): JsonResponse
    {
        $todo = $this->todo->findOneBy([
            ["user_id", auth()->user()->id],
            ["id", $todoId]
        ]);

        if(!$todo){
            return response()->json([
                "status" => Response::HTTP_FORBIDDEN,
                "success" => false,
                'error' => "You dont have permission to create task under this todo.",
            ], Response::HTTP_FORBIDDEN);
        }
        $task = $this->task->create([
            "name" => $name,
            "todo_id" => $todoId
        ]);

        return response()->json([
            "status" => Response::HTTP_CREATED,
            "success" => true,
            "message" => "Task created successfully",
            "data" => new TaskResource($task),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function showTask(int $id): JsonResponse
    {
        $task = $this->task->findWith($id, "todo");

        if($this->checkTaskUser($task) === false){
            return response()->json([
                "status" => Response::HTTP_FORBIDDEN,
                "success" => false,
                'error' => "You dont have permission to view this task.",
            ], Response::HTTP_FORBIDDEN);
        }

        if ($task){
            return response()->json([
                "status" => Response::HTTP_OK,
                "success" => true,
                "data" => new TaskResource($task),
            ], Response::HTTP_OK);
        }

        return response()->json([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            'error' => "Task not found",
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param int $id
     * @param string $name
     * @return JsonResponse
     */
    public function updateTask(int $id, string $name): JsonResponse
    {
        $task = $this->task->findWith($id, "todo");

        if($this->checkTaskUser($task) === false){
            return response()->json([
                "status" => Response::HTTP_FORBIDDEN,
                "success" => false,
                'error' => "You dont have permission to update this task.",
            ], Response::HTTP_FORBIDDEN);
        }

        if($task){
            $this->task->update([
                "name" => $name,
            ], $id);

            $task = $this->task->findWith($id, "todo");

            return response()->json([
                "status" => Response::HTTP_ACCEPTED,
                "success" => true,
                "message" => "Task name updated successfully",
                "data" => new TaskResource($task),
            ], Response::HTTP_ACCEPTED);
        }

        return response()->json([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            'error' => "Task not found",
        ], Response::HTTP_NOT_FOUND);
    }

    public function deleteTask(int $id): JsonResponse
    {
        $task = $this->task->findWith($id, "todo");

        if($this->checkTaskUser($task) === false){
            return response()->json([
                "status" => Response::HTTP_FORBIDDEN,
                "success" => false,
                'error' => "You dont have permission to delete this task.",
            ], Response::HTTP_FORBIDDEN);
        }

        if(!$task){
            return response()->json([
                "status" => Response::HTTP_NOT_FOUND,
                "success" => false,
                'error' => "Task not found",
            ], Response::HTTP_NOT_FOUND);
        }

        $this->task->delete($id);

        return response()->json([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => $task->name . " task deleted successfully",
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @param $task
     * @return bool
     */
    private function checkTaskUser($task): bool
    {
        if($task && $task->todo->user_id !== auth()->user()->id){
            return false;
        }
        return true;
    }


}
