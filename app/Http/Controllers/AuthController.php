<?php

namespace App\Http\Controllers;

use App\Events\Auth\LoginEvent;
use App\Events\Auth\RegisterEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    public function login(LoginRequest $request)
    {
        [$accessToken, $refreshToken] = $this->service->login();

        return response()->json([
            'accessToken' => $accessToken->plainTextToken,
            'refreshToken' => $refreshToken->plainTextToken,
        ], Response::HTTP_OK);
    }
    
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        [$accessToken, $refreshToken]  = $this->service->register($data);

        return response()->json([
            'accessToken' => $accessToken->plainTextToken,
            'refreshToken' => $refreshToken->plainTextToken,
        ], Response::HTTP_OK);
    }

    public function refresh(Request $request)
    {
        [$accessToken, $refreshToken] = $this->service->refresh($request);

        return response()->json([
            'accessToken' => $accessToken->plainTextToken,
            'refreshToken' => $refreshToken->plainTextToken,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
