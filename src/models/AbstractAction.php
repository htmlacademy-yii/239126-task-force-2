<?php

declare(strict_types=1);

namespace TaskForce\models;

/**
 * Абстрактный класс для действий
 */
abstract class AbstractAction
{
    /**
     * Возвращает название действия
     * @return string
     */
    abstract public static function getActionName(): string;

    /**
     * Возвращает статус код действия
     * @return int
     */
    abstract public static function getActionStatus(): int;

    /**
     * Метод проверки прав
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    abstract public static function checkPermission(int $executorId, int $customerId, int $activeId): bool;
}
