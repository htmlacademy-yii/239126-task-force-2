<?php

namespace Tests\unit\actions;

use PHPUnit\Framework\TestCase;
use TaskForce\models\actions\ActionCancel;

class ActionCancelTest extends TestCase
{
    public function testActionCancel(): void
    {
        $actionCancel = new ActionCancel();

        $this->assertEquals("Отменить", $actionCancel->getActionName());
        $this->assertEquals(2, $actionCancel->getActionStatus());
        $this->assertEquals(true, $actionCancel->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionCancel->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionCancel->checkPermission(1, 1, 3));
    }
}
