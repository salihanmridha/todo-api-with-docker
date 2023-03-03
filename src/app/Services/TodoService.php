<?php

namespace App\Services;

use App\Http\Resources\TodoResource;
use App\Services\Contracts\TodoServiceInterface;
use App\Repositories\Contracts\TodoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoService implements TodoServiceInterface
{
    private TodoRepositoryInterface $todo;

    public function __construct(TodoRepositoryInterface $todo)
    {
        $this->todo = $todo;
    }

    /**
     * @param string $name
     * @param string|null $description
     * @return JsonResponse
     */
    public function createTodo(string $name, ?string $description): JsonResponse
    {
        $todo = $this->todo->create([
            "name" => $name,
            "description" => $description,
            "user_id" => auth()->user()->id
        ]);

        return response()->json([
            "status" => Response::HTTP_CREATED,
            "success" => true,
            "message" => "TODO created successfully",
            "data" => new TodoResource($todo),
        ], Response::HTTP_CREATED);

    }

    /**
     * @return JsonResponse
     */
    public function todoList(): JsonResponse
    {
        $todos = $this->todo->findBy([
            ["user_id", auth()->user()->id]
        ]);

        return response()->json([
            "status" => Response::HTTP_OK,
            "success" => true,
            "data" => TodoResource::collection($todos),
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function showTodo(int $id): JsonResponse
    {
        $todo = $this->todo->findOneWithBy([
            ["id", $id],
            ["user_id", auth()->user()->id],
        ], "tasks");

        if ($todo){
            return response()->json([
                "status" => Response::HTTP_OK,
                "success" => true,
                "data" => new TodoResource($todo),
            ], Response::HTTP_OK);
        }

        return response()->json([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            'error' => "Todo not found",
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string|null $description
     * @return JsonResponse
     */
    public function updateTodo(int $id, string $name, ?string $description): JsonResponse
    {
        $todo = $this->todo->findOneBy([
            ["id", $id],
            ["user_id", auth()->user()->id],
        ]);

        if($todo){
            $this->todo->update([
                "name" => $name,
                "description" => $description,
            ], $id);

            $todo = $this->todo->findWith($id, "tasks");

            return response()->json([
                "status" => Response::HTTP_ACCEPTED,
                "success" => true,
                "message" => "Todo updated successfully",
                "data" => new TodoResource($todo),
            ], Response::HTTP_ACCEPTED);
        }

        return response()->json([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            'error' => "Todo not found",
        ], Response::HTTP_NOT_FOUND);

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteTodo(int $id): JsonResponse
    {
        $todo = $this->todo->findOneWithBy([
            ["id", $id],
            ["user_id", auth()->user()->id],
        ], "tasks");

        if(!$todo){
            return response()->json([
                "status" => Response::HTTP_NOT_FOUND,
                "success" => false,
                'error' => "Todo not found",
            ], Response::HTTP_NOT_FOUND);
        }

        if ($todo->tasks->count() > 0){
            return response()->json([
                "status" => Response::HTTP_FORBIDDEN,
                "success" => false,
                'error' => "Todo has associate tasks, Todo can not be delete",
            ], Response::HTTP_FORBIDDEN);
        }

        $this->todo->delete($id);

        return response()->json([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => $todo->name . " todo deleted successfully",
        ], Response::HTTP_ACCEPTED);


    }


}
