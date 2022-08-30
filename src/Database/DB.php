<?php

namespace Filimo\UrlShortener\Database;


use Filimo\UrlShortener\Database\Query\Builder;

class DB
{
    public static function table(string $table): Builder
    {
        return app()->queryBuilder($table);
    }

    public static function transaction($function): void
    {
        app()->getPdo()->beginTransaction();
        $function();
        app()->getPdo()->commit();
    }
}