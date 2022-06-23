<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionFinished;

class ActionFinishedTest extends TestCase
{
    public function testActionFinished(): void
    {
        $actionFinish = new ActionFinished();

        $this->assertEquals("Выполнено", $actionFinish->getActionName());
        $this->assertEquals(4, $actionFinish->getActionStatus());
        $this->assertEquals(true, $actionFinish->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionFinish->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionFinish->checkPermission(1, 1, 3));
    }
}
