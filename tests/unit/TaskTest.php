<?php

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use TaskForce\exceptions\TaskExecutorException;
use TaskForce\exceptions\TaskInvalidActionException;
use TaskForce\exceptions\TaskInvalidStatusException;
use TaskForce\models\Task;

class TaskTest extends TestCase
{
    public function testGetAvailableAction(): void
    {
        try {
            $res1 = new Task(customerId: 1, executorId: 2);

            // currentUserId - заказчик, статус задания Новый
            $this->assertEquals([Task::ACTION_BEGIN, Task::ACTION_CANCEL], $res1->getAvailableActions(1));

            // currentUsedId - исполнитель, статус заданий новый
            $this->assertEquals([Task::ACTION_RESPOND], $res1->getAvailableActions(10));
        } catch (TaskInvalidStatusException | TaskExecutorException $e) {
            $this->fail($e->getMessage());
        }

        try {
            $res2 = new Task(1, 2, Task::STATUS_WORK_IN_PROGRESS);

            // currentUsedId - заказчик, статус задания в процессе
            $this->assertEquals([Task::ACTION_FINISHED], $res2->getAvailableActions(1));

            // currentUserId - исполнитель, статус задания в процессе
            $this->assertEquals([Task::ACTION_DENIED], $res2->getAvailableActions(2));
        } catch (TaskInvalidStatusException | TaskExecutorException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testExceptionConstructor(): void
    {
        try {
            new Task(customerId: 1, executorId: 2, status: 10);
            $this->fail("TaskForceBaseException was not thrown");
        } catch (TaskInvalidStatusException $e) {
            $this->assertEquals("Неверный статус", $e->getMessage());
        } catch (TaskExecutorException $e) {
            $this->fail($e->getMessage());
        }

        try {
            new Task(customerId: 1, executorId: null, status: 3);
            $this->fail("TaskExecutorException was not thrown");
        } catch (TaskExecutorException $e) {
            $this->assertEquals("Для данного статуса обязательно нужен исполнитель", $e->getMessage());
        } catch (TaskInvalidStatusException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetNextStatus(): void
    {
        try {
            $res = new Task(customerId: 1, executorId: 2);

            $this->assertEquals(Task::STATUS_WORK_IN_PROGRESS, $res->getNextStatus(Task::ACTION_BEGIN));
            $this->assertEquals(Task::STATUS_CANCELLED, $res->getNextStatus(Task::ACTION_CANCEL));
            $this->assertEquals(Task::STATUS_NEW, $res->getNextStatus(Task::ACTION_RESPOND));
            $this->assertEquals(Task::STATUS_FINISHED, $res->getNextStatus(Task::ACTION_FINISHED));
            $this->assertEquals(Task::STATUS_FAILED, $res->getNextStatus(Task::ACTION_DENIED));
        } catch (TaskInvalidActionException | TaskInvalidStatusException | TaskExecutorException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testGetNextStatusException(): void
    {
        try {
            $res = new Task(customerId: 1, executorId: 2);
            $res->getNextStatus(15);
            $this->fail("TaskInvalidActionException was not thrown");
        } catch (TaskInvalidActionException $e) {
            $this->assertEquals("Неверное действие", $e->getMessage());
        } catch (TaskInvalidStatusException | TaskExecutorException $e) { // unexpected exception in this unit test
            $this->fail($e->getMessage());
        }
    }
}
