<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionRespond;

class ActionRespondTest extends TestCase
{
    public function testActionRespond(): void
    {
        $this->assertEquals("Откликнуться", ActionRespond::getActionName());
        $this->assertEquals(3, ActionRespond::getActionStatus());
        $this->assertEquals(true, ActionRespond::checkPermission(1, 2, 1));
        $this->assertEquals(false, ActionRespond::checkPermission(1, 2, 2));
        $this->assertEquals(false, ActionRespond::checkPermission(1, 1, 3));
    }
}
