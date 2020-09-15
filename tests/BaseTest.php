<?php

namespace the42coders\Workflows\Tests;

use the42coders\Workflows\WorkflowsServiceProvider;

class BaseTest extends TestCase
{
    public function testIfThePhpUnitRuns()
    {
        $this->assertTrue(true);
    }

    public function testIfTheServiceProviderBoots()
    {
        $serviceProvider = new WorkflowsServiceProvider(app());
        $serviceProvider->boot();

        $this->assertInstanceOf(WorkflowsServiceProvider::class, $serviceProvider);
    }
}
