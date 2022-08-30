<?php

namespace Tests;

use Filimo\UrlShortener\Database\DB;

class ExampleTest extends TestCase
{
    public function testHello()
    {
        $users = DB::table('users')->all();

        $this->assertEquals($users, collect());
    }
}