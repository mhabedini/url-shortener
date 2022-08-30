<?php

namespace Tests;

use Exception;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

trait CreatesApplication
{
    /**
     * @throws Exception
     */
    public function createApplication()
    {
        require __DIR__ . '/../bootstrap/app.php';
        $app = new PhinxApplication();
        $app->setAutoExit(false);
        $app->run(new StringInput('migrate'), new NullOutput());
    }
}