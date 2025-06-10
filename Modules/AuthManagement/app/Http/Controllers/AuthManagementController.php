<?php

namespace Modules\AuthManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\AuthManagement\Http\Requests\LoginUserRequest;
use Modules\AuthManagement\Services\JwtService;
use Modules\AuthManagement\Transformers\TokenResource;
use Modules\AuthManagement\Transformers\UserResource;

class AuthManagementController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse|TokenResource
    {
        // Authenticated Users Can't actually log in again.
        if (Auth::check()) {
            return response()->json(['message' => 'Already Logged In!'], 404);
        }


        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, remember: true)) {
            $user = Auth::guard('web')->user();

            //Token Payload
            $payload = [
                'sub' => $user->id,
                'iat' => now()->timestamp,
                'exp' => now()->addSeconds(config('jwt.ttl', 3600))->timestamp,
            ];

            //Session Generation
            $request->session()->regenerate();

            //JWT Token Generation
            $access_token = JwtService::generateToken($payload);

            $response = [
                'access_token' => $access_token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl', 3600),
                'whoami' => $user
            ];

            return new TokenResource($response);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Successfully logged out'], 202);
    }
}
