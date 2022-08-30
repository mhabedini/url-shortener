<?php

namespace Filimo\UrlShortener\Service;

use Exception;
use Filimo\UrlShortener\Database\DB;

class LinkShortenerService
{
    /**
     * @throws Exception
     */
    public static function create(string $originalLink, ?string $title = null, ?int $userId = null)
    {
        return DB::transaction(function () use ($userId, $title, $originalLink) {
            $link = DB::table('links')->where('original_link', '=', $originalLink)->first();
            if (!is_null($link)) {
                return $originalLink;
            }

            do {
                $random = rand_str(6);
                $randomStr = DB::table('links')->where('short_link', '=', $random)->exists();
            } while ($randomStr);

            return DB::table('links')->create([
                'original_link' => $originalLink,
                'title' => $title,
                'user_id' => $userId,
                'short_link' => $random,
            ]);
        }, 5);
    }
}