<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionBegin;

class ActionBeginTest extends TestCase
{
    public function testActionBegin(): void
    {
        $actionBegin = new ActionBegin();

        $this->assertEquals("Начать задание", $actionBegin->getActionName());
        $this->assertEquals(1, $actionBegin->getActionStatus());
        $this->assertEquals(true, $actionBegin->checkPermission(1, 2, 1));
        $this->assertEquals(false, $actionBegin->checkPermission(1, 2, 2));
        $this->assertEquals(false, $actionBegin->checkPermission(1, 1, 2));
    }
}
