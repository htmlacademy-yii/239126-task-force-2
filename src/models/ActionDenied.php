<?php

declare(strict_types=1);

namespace TaskForce\models;

use TaskForce\models\AbstractAction;

class ActionDenied extends AbstractAction
{
    /**
     * Возвращает название действия
     * @return string
     */
    public static function getActionName(): string
    {
        return "Отказаться";
    }

    /**
     * Возвращает статус код действия
     * @return int
     */
    public static function getActionStatus(): int
    {
        return 5;
    }

    /**
     * Метод проверки прав
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    public static function checkPermission(int $executorId, int $customerId, int $activeId): bool
    {
        return $customerId === $activeId;
    }
}
