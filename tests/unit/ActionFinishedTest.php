<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionFinished;

class ActionFinishedTest extends TestCase
{
    public function testActionFinished(): void
    {
        $this->assertEquals("Выполнено", ActionFinished::getActionName());
        $this->assertEquals(4, ActionFinished::getActionStatus());
        $this->assertEquals(true, ActionFinished::checkPermission(1, 2, 2));
        $this->assertEquals(false, ActionFinished::checkPermission(1, 2, 1));
        $this->assertEquals(false, ActionFinished::checkPermission(1, 1, 3));
    }
}
