<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait RequestResponseFormatTrait
{
    /*
     * Response on success request
     * */
    protected function success($data = null, int $dataCounter = null, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Success',
            'statusCode' => $code,
            'counter' => $dataCounter,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /*
     * Response on error request
     * */
    protected function error(string $message = null, int $code, $data = null) : JsonResponse
    {
        return response()->json([
                'status' => 'Error',
                'statusCode' => $code,
                'message' => $message,
                'data' => $data
            ]
        //, $code
        );
    }
}
