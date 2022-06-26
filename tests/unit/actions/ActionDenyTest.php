<?php

namespace Tests\unit\actions;

use PHPUnit\Framework\TestCase;
use TaskForce\models\actions\ActionDeny;

class ActionDenyTest extends TestCase
{
    public function testActionDenied(): void
    {
        $actionDeny = new ActionDeny();

        $this->assertEquals("Отказаться", $actionDeny->getActionName());
        $this->assertEquals(5, $actionDeny->getActionStatus());
        $this->assertEquals(true, $actionDeny->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionDeny->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionDeny->checkPermission(1, 1, 2));
    }
}
