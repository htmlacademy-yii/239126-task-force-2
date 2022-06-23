<?php

declare(strict_types=1);

namespace TaskForce\models;

/**
 * Абстрактный класс для действий
 */
abstract class AbstractAction
{
    protected string $name;
    protected int $code;

    public function __construct(string $name_, int $code_)
    {
        $this->name = $name_;
        $this->code = $code_;
    }

    /**
     * Возвращает название действия
     * @return string
     */
    public function getActionName(): string
    {
        return $this->name;
    }

    /**
     * Возвращает статус код действия
     * @return int
     */
    public function getActionStatus(): int
    {
        return $this->code;
    }

    /**
     * Метод проверки прав
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    abstract public static function checkPermission(int $executorId, int $customerId, int $activeId): bool;
}
