<?php

namespace Swis\Laravel\Fulltext\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Orchestra\Testbench\TestCase;
use Swis\Laravel\Fulltext\FulltextServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected function getPackageProviders($app): array
    {
        return [
            FulltextServiceProvider::class,
        ];
    }
}
