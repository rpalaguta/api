<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Return a success response with a message and optional data.
     *
     * @param string $message
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message, $data = null, $status = 200)
    {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $status);
    }

    /**
     * Return an error response with a message.
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $status = 400)
    {
        return response()->json(['error' => $message], $status);
    }
}
