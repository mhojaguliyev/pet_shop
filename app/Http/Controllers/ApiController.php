<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use JsonSerializable;

class ApiController extends Controller
{
    /**
     * @param string $message
     * @param array<string, string|true|JsonSerializable>|JsonSerializable $data
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse(string $message = 'OK', array|JsonSerializable $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
