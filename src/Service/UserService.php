<?php

namespace Mhabedini\UrlShortener\Service;

use Mhabedini\UrlShortener\Support\Database\DB;

class UserService
{
    public static function create(string $email, string $username, string $password, ?string $firstName = null, ?string $lastName = null)
    {
        return DB::table('users')->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'username' => $username,
            'password' => hash('sha256', $password),
        ]);
    }
}