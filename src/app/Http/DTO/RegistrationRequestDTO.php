<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Registration Request DTO",
 *     description="Registration Request DTO",
 *     type="object",
 *     required={"name", "email", "password"}
 * )
 */
class RegistrationRequestDTO extends Data
{
    public function __construct(
        /**
         * @OA\Property(
         *      title="name",
         *      description="Name of the user",
         *      example="Salihan Mridha"
         * )
         *
         * @var string
         */
        public readonly string $name,
        /**
         * @OA\Property(
         *      title="email",
         *      description="Email of the user",
         *      example="salihanmridha@gmail.com"
         * )
         *
         * @var string
         */
        public readonly string $email,
        /**
         * @OA\Property(
         *      title="password",
         *      description="Password of the user",
         *      example="123456"
         * )
         *
         * @var string
         */
        public readonly string $password,
    )
    {
    }
}
