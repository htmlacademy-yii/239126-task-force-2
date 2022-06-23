<?php

declare(strict_types=1);

namespace TaskForce\models;

class ActionCancel extends AbstractAction
{
    public function __construct()
    {
        $this->name = "Отменить";
        $this->code = 2;
    }

    /**
     * Метод проверки прав
     * Возвращает true в случае если текущий пользователь
     * является исполнителем задания
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    public static function checkPermission(int $executorId, int $customerId, int $activeId): bool
    {
        return $executorId !== $customerId && $executorId === $activeId;
    }
}
