<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Task Response DTO",
 *     description="Task response DTO",
 *     type="object",
 * )
 */
class TaskResponseDTO extends Data
{
    public function __construct(
        /**
         * @OA\Property(
         *      title="status",
         *      example=200
         * )
         *
         * @var int
         */
        public readonly int $status,
        /**
         * @OA\Property(
         *      title="success",
         *      example=true
         * )
         *
         * @var bool
         */
        public readonly bool $success,


        /**
         * @OA\Property(
         *     title = "data",
         *     type="object",
         *     @OA\Property(
                    property="id",
         *          type="int",
         *          example=1,
         *     ),
         *     @OA\Property(
                    property="name",
         *          type="string",
         *          example="My first todo",
         *     ),
         *     @OA\Property(
                    property="todo_id",
         *          type="int",
         *          example=1,
         *     ),
         *     @OA\Property(
                    property="created_at",
         *          type="string",
         *          example="2023-03-02T12:46:12.000000Z",
         *     ),
         *     @OA\Property(
                    property="updated_at",
         *          type="string",
         *          example="2023-03-02T12:46:12.000000Z",
         *     ),
         * )
         */
        public readonly array $data,
    )
    {
    }
}
