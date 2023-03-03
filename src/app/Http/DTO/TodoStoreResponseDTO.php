<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Todo stoere Response DTO",
 *     description="Todo store response DTO",
 *     type="object",
 * )
 */
class TodoStoreResponseDTO extends Data
{
    public function __construct(
        /**
         * @OA\Property(
         *      title="status",
         *      example=201
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
         *      title="message",
         *      example="TODO created successfully"
         * )
         *
         * @var string
         */
        public readonly string $message,


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
                    property="description",
         *          type="string",
         *          example="my todo description",
         *     ),
         *     @OA\Property(
                    property="user_id",
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
