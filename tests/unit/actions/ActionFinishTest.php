<?php

namespace Tests\unit\actions;

use PHPUnit\Framework\TestCase;
use TaskForce\models\actions\ActionFinish;

class ActionFinishTest extends TestCase
{
    public function testActionFinished(): void
    {
        $actionFinish = new ActionFinish();

        $this->assertEquals("Выполнено", $actionFinish->getActionName());
        $this->assertEquals(4, $actionFinish->getActionStatus());
        $this->assertEquals(true, $actionFinish->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionFinish->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionFinish->checkPermission(1, 1, 3));
    }
}
