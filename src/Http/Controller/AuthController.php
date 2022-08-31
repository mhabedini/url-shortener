<?php

namespace Filimo\UrlShortener\Http\Controller;

use Filimo\UrlShortener\Exception\HttpException;
use Filimo\UrlShortener\Support\Database\DB;
use Filimo\UrlShortener\Support\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $user = $this->authenticate($data['username'], $data['password']);

        if ($user) {
            throw new HttpException('The username or password is wrong', 400);
        }
        unset($user['password']);
        $token = $this->createSession($user);
        return apiResponse([
            'token' => $token,
        ]);
    }

    public function signup(Request $request): string
    {
        $user = DB::table('users')->create([
            'first_name' => $request->get('firstname'),
            'last_name' => $request->get('last_name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => hash('sha256', $request->get('password')),
        ]);
        $token = $this->createSession($user);
        unset($user['password']);
        $user['token'] = $token;
        return apiResponse($user);
    }

    private function authenticate(string $username, string $password): ?array
    {
        return DB::table('users')->where('username', '=', $username)
            ->where('password', '=', hash('sha256', $password))
            ->first();
    }

    private function createSession(array $user): string
    {
        $token = rand_str(32);
        DB::table('sessions')->create([
            'user_id' => $user['id'],
            'token' => hash('sha256', $token),
        ]);
        return $token;
    }
}