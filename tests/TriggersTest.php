<?php

namespace the42coders\Workflows\Tests;

use the42coders\Workflows\Triggers\ObserverTrigger;
use the42coders\Workflows\Triggers\Trigger;

class TriggersTest extends TestCase
{
    /** @test */
    public function observerTriggerGetInputFields()
    {
        $observerTrigger = new ObserverTrigger();

        $this->assertTrue(is_array($observerTrigger->inputFields()));
    }

    /** @test */
    public function triggerTest()
    {
        $trigger = new Trigger();

        $this->assertStringContainsString(__('workflows::workflows.Settings'), $trigger->getSettings());
    }
}
