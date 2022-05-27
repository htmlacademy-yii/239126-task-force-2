<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use TaskForce\Task;

class GetAvailableActionTest extends TestCase
{
    public function testGetAvailableAction()
    {
        $res1 = new Task(customerId: 1, executorId: 2);

        // currentUserId - заказчик, статус задания Новый
        $this->assertEquals([Task::ACTION_BEGIN, Task::ACTION_CANCEL], $res1->getAvailableActions(1));

        // currentUsedId - исполнитель, статус заданий новый
        $this->assertEquals([Task::ACTION_RESPOND], $res1->getAvailableActions(10));

        $res2 = new Task(1, 2, Task::STATUS_WORK_IN_PROGRESS);

        // currentUsedId - заказчик, статус задания в процессе
        $this->assertEquals([Task::ACTION_FINISHED], $res2->getAvailableActions(1));

        // currentUserId - исполнитель, статус задания в процессе
        $this->assertEquals([Task::ACTION_DENIED], $res2->getAvailableActions(2));
    }
}
