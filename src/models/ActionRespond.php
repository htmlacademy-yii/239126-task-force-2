<?php

declare(strict_types=1);

namespace TaskForce\models;

class ActionRespond extends AbstractAction
{
    public function __construct()
    {
        $this->name = "Откликнуться";
        $this->code = 3;
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
    public function checkPermission(int $executorId, int $customerId, int $activeId): bool
    {
        return $customerId !== $executorId && $executorId === $activeId;
    }
}
