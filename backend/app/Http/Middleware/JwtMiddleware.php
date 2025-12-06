<?php
namespace App\Http\Middleware;

use App\Services\JwtService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->cookie('token');

        if (! $token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $jwtService = new JwtService();
        $payload    = $jwtService->validateToken($token);

        if (! $payload) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Set user for Auth facade
        $user = \App\Models\User::find($payload['sub']);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 401);
        }

        Auth::setUser($user);

        // Inject tenant_id into request for easy access
        $request->attributes->set('tenant_id', $payload['tenant_id'] ?? null);

        return $next($request);
    }
}
