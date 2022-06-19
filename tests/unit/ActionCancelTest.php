<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionCancel;

class ActionCancelTest extends TestCase
{
    public function testActionCancel(): void
    {
        $this->assertEquals("Отменить", ActionCancel::getActionName());
        $this->assertEquals(2, ActionCancel::getActionStatus());
        $this->assertEquals(true, ActionCancel::checkPermission(1, 2, 1));
        $this->assertEquals(false, ActionCancel::checkPermission(1, 2, 2));
        $this->assertEquals(false, ActionCancel::checkPermission(1, 1, 3));
    }
}
