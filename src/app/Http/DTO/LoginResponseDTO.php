<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Login Response DTO",
 *     description="Login response DTO",
 *     type="object",
 * )
 */
class LoginResponseDTO extends Data
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
         *      title="message",
         *      example="Login successfully!"
         * )
         *
         * @var string
         */
        public readonly string $message,
        /**
         * @OA\Property(
         *      title="access_token",
         *      example="1|41MXUHPB56YoGyvgjMt5WTKviKIckEm3RmrkXKH4"
         * )
         *
         * @var string
         */
        public readonly string $access_token,
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
         *          example="Salihan Mridha",
         *     ),
         *     @OA\Property(
                    property="email",
         *          type="string",
         *          example="salihanmridha@gmail.com",
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
