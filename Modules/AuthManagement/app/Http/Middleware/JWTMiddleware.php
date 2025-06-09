<?php

namespace Modules\AuthManagement\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Modules\AuthManagement\Services\JwtService;
use phpDocumentor\Reflection\Types\Integer;

readonly class JWTMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Token required',
                'message' => 'Please provide a valid Bearer token'
            ], 401)->header("WWW-Authenticate", "Bearer");
        }

        try {
            $payload = JwtService::decodeToken($token);
            $user = User::find($payload->sub);

            $request->setUserResolver(function () use ($user) {
                return $user;
            });

        }
        catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid token',
                'message' => $e->getMessage()
            ], 401)->header('WWW-Authenticate', 'Bearer realm="API", error="invalid_token"');
        }

        return $next($request);
    }
}
