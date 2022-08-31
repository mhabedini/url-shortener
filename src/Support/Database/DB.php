<?php

namespace Filimo\UrlShortener\Support\Database;


use Exception;
use Filimo\UrlShortener\Support\Database\Query\Builder;

class DB
{
    public static function table(string $table): Builder
    {
        return app()->queryBuilder($table);
    }

    /**
     * @throws Exception
     */
    public static function transaction($function, int $retry)
    {
        do {
            try {
                app()->getPdo()->beginTransaction();
                $result = $function();
                app()->getPdo()->commit();
                return $result;
            } catch (Exception $exception) {
                app()->getPdo()->rollBack();
                $retry--;
                if ($retry == 0) {
                    throw  $exception;
                }
            }
        } while (true);
    }
}