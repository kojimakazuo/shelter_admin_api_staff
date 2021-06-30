<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthCollection;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'refresh']]);
    }

    public function login()
    {
        $credentials = request(['login_id', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout(Request $request)
    {
        auth()->logout();
    }

    public function refresh()
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (TokenBlackListedException | TokenExpiredException | TokenInvalidException | JWTException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    protected function respondWithToken($token)
    {
        return new AuthCollection([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
