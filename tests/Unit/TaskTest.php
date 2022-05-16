<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Task;

class TaskTest extends TestCase
{
    public function testTask()
    {
        $res = Task::getFive();

        $this->assertEquals(5, $res);
    }
}
