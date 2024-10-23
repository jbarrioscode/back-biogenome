<?php

namespace App\Traits;

trait AuthenticationTrait
{
    /**
     * Return a success JSON response.
     *
     * @param array|string $data
     * @param string $message
     * @param int|null $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, $dataCounter = null, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'statusCode' => $code,
            'counter' => $dataCounter,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $code
     * @param array|string|null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, int $code, $data = null)
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
