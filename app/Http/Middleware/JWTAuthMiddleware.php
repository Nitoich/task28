<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JWTService;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if(!$token) {
            $this->throwUnauthorized();
        }
        $service = app()->make(JWTService::class);
        if(!$service->verify($token)) {
            $this->throwUnauthorized();
        }
        $payload = $service->getPayload($token);
        $user = User::query()->find($payload['ur_id']);
        if(!$user) {
            $this->throwUnauthorized();
        }

        Auth::login($user);
        return $next($request);
    }

    public function throwUnauthorized(): void
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized'
            ]
        ])->setStatusCode(401));
    }
}
