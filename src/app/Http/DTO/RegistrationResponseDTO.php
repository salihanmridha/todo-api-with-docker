<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Registration Response DTO",
 *     description="Registration response DTO",
 *     type="object",
 * )
 */
class RegistrationResponseDTO extends Data
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
         *      example="User created successfully"
         * )
         *
         * @var string
         */
        public readonly string $message,
    )
    {
    }
}
