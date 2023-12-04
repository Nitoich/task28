<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\Auth\LoginRequest;
use App\Http\Requests\api\v1\Auth\RegisterRequest;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());
        $session = Session::fastCreate($user->id);
        $refresh_token_cookie = cookie('refresh_token', $session->token, 60*24*30);
        return response()->json([
            'data' => [
                'access_token' => $session->access_token
            ]
        ])->setStatusCode(201)->cookie($refresh_token_cookie);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email);
        if(!Hash::check($request->password, $user->password)) {
            throw new UnauthorizedException('Incorrect email or password');
        }
        $session = Session::fastCreate($user->id);
        $refresh_token_cookie = cookie('refresh_token', $session->token, 60*24*30);
        return response()->json([
            'data' => [
                'access_token' => $session->access_token
            ]
        ])->setStatusCode(201)->cookie($refresh_token_cookie);
    }
}
