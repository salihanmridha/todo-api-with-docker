<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Todo Request DTO",
 *     description="Todo Request DTO",
 *     type="object",
 *     required={"name"}
 * )
 */
class TodoRequestDTO extends Data
{
    public function __construct(
        /**
         * @OA\Property(
         *      title="name",
         *      description="Name of todo",
         *      example="My todo name"
         * )
         *
         * @var string
         */
        public readonly string $name,
        /**
         * @OA\Property(
         *      title="description",
         *      description="Todo description",
         *      example="My todo description"
         * )
         *
         * @var string
         */
        public readonly ?string $description,
    )
    {
    }
}
