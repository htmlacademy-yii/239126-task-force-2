<?php

declare(strict_types=1);

namespace TaskForce\models;

class ActionRespond extends AbstractAction
{
    /**
     * Возвращает название действия
     * @return string
     */
    public static function getActionName(): string
    {
        return "Откликнуться";
    }

    /**
     * Возвращает статус код действия
     * @return int
     */
    public static function getActionStatus(): int
    {
        return 3;
    }

    /**
     * Метод проверки прав
     * Возвращает true если текущий пользователь
     * является исполнителем задания
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    public static function checkPermission(int $executorId, int $customerId, int $activeId): bool
    {
        return $executorId === $activeId;
    }
}
