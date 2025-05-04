<?php

namespace App\Services;

use App\Enums\TokenAbility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Passport;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function login()
    {
        return $this->createToken(Auth::user());
    }

    public function register(array $data)
    {
        $user = User::create($data);

        return $this->createToken($user);
    }

    public function refresh(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        $user = $token->tokenable;

        return $this->createToken($user);
    }

    public function createToken(User $user)
    {
        $user->tokens()->delete();

        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

        return [$accessToken, $refreshToken];
    }
}
