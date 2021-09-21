<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthCollection;
use Illuminate\Cookie\CookieJar;
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

    public function login(Request $request, CookieJar $cookie)
    {
        $credentials = request(['login_id', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->unauthorized();
        }
        if ($request['type'] == 'cookie') {
            return $this->respondWithCookie($request, $cookie, $token);
        } else {
            return $this->respondWithToken($token);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
    }

    public function refresh(Request $request, CookieJar $cookie)
    {
        try {
            $token = auth()->refresh();
            if ($request['type'] == 'cookie') {
                return $this->respondWithCookie($request, $cookie, $token);
            } else {
                return $this->respondWithToken($token);
            }
        } catch (TokenBlackListedException | TokenExpiredException | TokenInvalidException | JWTException $e) {
            return response()->unauthorized();
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

    protected function respondWithCookie(Request $request, CookieJar $cookie, $token)
    {
        return response()->json($this->respondWithToken($token), 200)->withCookie($cookie->make(
            config('cookie.token.key'),
            $token,
            config('cookie.token.expire'),
            config('cookie.token.path'),
            config('cookie.token.domain'),
            $request->getScheme() === config('cookie.token.scheme'),
            config('cookie.token.http_only')
        ));
    }
}
