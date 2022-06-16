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
     * @param int $executorId
     * @param int $currentUserId
     * @param int $customerId
     * @return bool
     */
    abstract public static function checkPermission(int $executorId, int $currentUserId, int $customerId): bool;
}
