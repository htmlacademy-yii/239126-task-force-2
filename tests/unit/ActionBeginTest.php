<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\models\ActionBegin;

class ActionBeginTest extends TestCase
{
    public function testGetActionBegin(): void
    {
        $this->assertEquals("Начать задание", ActionBegin::getActionName());
        $this->assertEquals(1, ActionBegin::getActionStatus());
        $this->assertEquals(true, ActionBegin::checkPermission(1, 2, 1));
        $this->assertEquals(false, ActionBegin::checkPermission(1, 2, 2));
    }
}
