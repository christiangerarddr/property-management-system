<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

interface ResponseInterface
{
    public static function success($data = null, string $message = 'The request was processed successfully.', int $statusCode = 200): JsonResponse;

    public static function error($data = null, string $message = 'An error occurred', int $statusCode = 400): JsonResponse;

    public static function json(mixed $data, int $statusCode = 200): JsonResponse;
}
