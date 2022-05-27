<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use TaskForce2\Task;

class GetNextStatusTest extends TestCase
{
    public function testGetNextStatus()
    {
        $res = new Task(customerId: 1, executorId: 2);

        $this->assertEquals(Task::STATUS_WORK_IN_PROGRESS, $res->getNextStatus(Task::ACTION_BEGIN));
        $this->assertEquals(Task::STATUS_CANCELLED, $res->getNextStatus(Task::ACTION_CANCEL));
        $this->assertEquals(Task::STATUS_NEW, $res->getNextStatus(Task::ACTION_RESPOND));
        $this->assertEquals(Task::STATUS_FINISHED, $res->getNextStatus(Task::ACTION_FINISHED));
        $this->assertEquals(Task::STATUS_FAILED, $res->getNextStatus(Task::ACTION_DENIED));
    }
}
