<?php

namespace Mhabedini\UrlShortener\Http\Controller;

use Mhabedini\UrlShortener\Exception\HttpException;
use Mhabedini\UrlShortener\Support\Database\DB;

class Controller
{
    /**
     * @throws HttpException
     */
    protected function authorize($throw = false): ?array
    {
        $token = request()->header('Authorization');
        $session = DB::table('sessions')->where('token', '=', hash('sha256', $token))
            ->where('expires_at', 'is', null)
            ->first();

        if (!$session && $throw) {
            throw new HttpException('You are not authorized', 403);
        }

        if (!$session) {
            return null;
        }

        return DB::table('users')->find($session['user_id']);
    }
}