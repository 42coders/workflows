<?php

namespace the42coders\Workflows\Tests;

use the42coders\Workflows\DataBuses\DataBus;
use the42coders\Workflows\Tasks\Task;

class DataBusTest extends TestCase
{
    /** @test */
    public function DataBusCanHandleArrayInConstructor()
    {
        $dataBus = new DataBus(['test' => 'value']);

        $this->assertSame($dataBus->get('test'), 'value');
    }

    /** @test */
    public function DataBusSetOutput()
    {
        $dataBus = new DataBus([]);
        $dataBus->setOutput('test', 'value');

        $this->assertSame($dataBus->get('test'), 'value');
    }

    /** @test */
    public function DataBusSetOutputArray()
    {
        $dataBus = new DataBus([]);
        $dataBus->setOutputArray('test', 'value');

        $this->assertTrue(is_array($dataBus->get('test')));
    }

    /** @test */
    public function DataBusToString()
    {
        $dataBus = new DataBus([]);
        $dataBus->setOutput('test', 'value');

        $this->assertSame($dataBus->toString(), 'value\n');
    }

    /** @test */
    public function DataBusCollectData()
    {
        $dataBus = new DataBus([]);

        $dataBus->setOutput('field1', 'field_key1');
        $dataBus->setOutput('field2', 'field_key2');

        $fields = [
            'field1' => ['value' => 'test'],
            'field1' => ['value' => 'test'],
        ];

        $dataBus->collectData(new Task(), $fields);

        $this->assertSame($dataBus->get('field1'), 'test');
    }
}
