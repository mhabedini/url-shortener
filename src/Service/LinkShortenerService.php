<?php

namespace Mhabedini\UrlShortener\Service;

use Exception;
use Mhabedini\UrlShortener\Support\Database\DB;

class LinkShortenerService
{
    public static function index(int $userId = null): array
    {
        return DB::table('links')->where('user_id', '=', $userId)->get();
    }

    public static function show(string $hash): ?array
    {
        return DB::table('links')->where('short_link', '=', $hash)->first();
    }

    /**
     * @throws Exception
     */
    public static function store(string $originalLink, ?string $title = null, ?int $userId = null): array
    {
        return DB::transaction(function () use ($userId, $title, $originalLink) {
            $link = DB::table('links')->where('original_link', '=', $originalLink)->first();
            if (!is_null($link)) {
                return $link;
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

    public static function delete(int $linkId): bool
    {
        return DB::table('links')->delete($linkId);
    }

    public static function update(int $linkId, array $data): array
    {
        DB::table('links')->where('id', '=', $linkId)->update($data);
        return DB::table('links')->find($linkId);
    }
}