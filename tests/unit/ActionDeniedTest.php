<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionDenied;

class ActionDeniedTest extends TestCase
{
    public function testActionDenied(): void
    {
        $this->assertEquals("Отказаться", ActionDenied::getActionName());
        $this->assertEquals(5, ActionDenied::getActionStatus());
        $this->assertEquals(true, ActionDenied::checkPermission(1, 2, 2));
        $this->assertEquals(false, ActionDenied::checkPermission(1, 2, 1));
        $this->assertEquals(false, ActionDenied::checkPermission(1, 1, 2));
    }
}
