<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Task Request DTO",
 *     description="Task Request DTO",
 *     type="object",
 *     required={"name", "todo_id"}
 * )
 */
class TaskRequestDTO extends Data
{
    public function __construct(
        /**
         * @OA\Property(
         *      title="name",
         *      description="Name of task",
         *      example="My task name"
         * )
         *
         * @var string
         */
        public readonly string $name,
        /**
         * @OA\Property(
         *      title="todo_id",
         *      description="Todo id",
         *      example=1
         * )
         *
         * @var int
         */
        public readonly int $todo_id,
    )
    {
    }
}
