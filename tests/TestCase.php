<?php

namespace Tests;

use Exception;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->createApplication();
        parent::setUp();
    }
}