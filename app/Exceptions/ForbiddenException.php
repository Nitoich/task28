<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => 403,
                'message' => 'Forbidden!'
            ]
        ])->setStatusCode(403);
    }
}
