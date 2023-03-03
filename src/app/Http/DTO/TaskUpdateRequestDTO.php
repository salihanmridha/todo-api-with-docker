<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Task update Request DTO",
 *     description="Task update Request DTO",
 *     type="object",
 *     required={"name"}
 * )
 */
class TaskUpdateRequestDTO extends Data
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
    )
    {
    }
}
