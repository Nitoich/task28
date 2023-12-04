<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\ShareAccess\CreateShareRequest;
use App\Models\ShareAccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareAccessController extends Controller
{
    public function store(CreateShareRequest $request): JsonResponse
    {
        $share = ShareAccess::query()->create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));
        return response()->json([
            'data' => $share
        ])->setStatusCode(201);
    }

    public function destroy(ShareAccess $access): JsonResponse
    {
        $access->delete();
        return response()->json([
            'data' => $access
        ])->setStatusCode(200);
    }
}
