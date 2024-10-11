<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Response implements ResponseInterface
{
    public static function success($data = null, string $message = 'The request was processed successfully.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function error($data = null, string $message = 'An error occurred', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function json(mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
