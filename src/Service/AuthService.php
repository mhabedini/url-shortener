<?php

namespace Filimo\UrlShortener\Service;

use Filimo\UrlShortener\Exception\HttpException;
use Filimo\UrlShortener\Support\Database\DB;
use Filimo\UrlShortener\Support\Http\Request;

class AuthService
{
    public static function login(Request $request): string
    {
        $data = $request->all();
        $user = self::authenticate($data['username'], $data['password']);

        if (!$user) {
            throw new HttpException('The username or password is wrong', 400);
        }
        unset($user['password']);
        return self::createSession($user);
    }

    public static function register(Request $request)
    {
        $user = DB::table('users')->create([
            'first_name' => $request->get('firstname'),
            'last_name' => $request->get('last_name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => hash('sha256', $request->get('password')),
        ]);
        $token = self::createSession($user);
        unset($user['password']);
        $user['token'] = $token;
        return $user;
    }

    public static function createSession(array $user): string
    {
        $token = rand_str(32);
        DB::table('sessions')->create([
            'user_id' => $user['id'],
            'token' => hash('sha256', $token),
        ]);
        return $token;
    }

    public static function authenticate(string $username, string $password): ?array
    {
        return DB::table('users')->where('username', '=', $username)
            ->where('password', '=', hash('sha256', $password))
            ->first();
    }
}