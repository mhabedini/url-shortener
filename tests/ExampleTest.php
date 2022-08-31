<?php

namespace Tests;

use Filimo\UrlShortener\Service\LinkShortenerService;

class ExampleTest extends TestCase
{
    public function testHello()
    {
        //$user = UserService::create('m.h.a.abedini@gmail.com', 'test', 'test123456');
        $link = LinkShortenerService::index();
        var_dump($link);
    }
}