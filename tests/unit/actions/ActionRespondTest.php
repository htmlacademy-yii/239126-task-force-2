<?php

namespace Tests\unit\actions;

use PHPUnit\Framework\TestCase;
use TaskForce\models\actions\ActionRespond;

class ActionRespondTest extends TestCase
{
    public function testActionRespond(): void
    {
        $actionRespond = new ActionRespond();

        $this->assertEquals("Откликнуться", $actionRespond->getActionName());
        $this->assertEquals(3, $actionRespond->getActionStatus());
        $this->assertEquals(true, $actionRespond->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionRespond->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionRespond->checkPermission(1, 1, 3));
    }
}
