<?php

namespace the42coders\Workflows\Tests;

use Orchestra\Testbench\TestCase;
use the42coders\Workflows\WorkflowsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [WorkflowsServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
