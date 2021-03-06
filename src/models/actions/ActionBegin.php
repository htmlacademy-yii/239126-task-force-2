<?php

declare(strict_types=1);

namespace TaskForce\models\actions;

class ActionBegin extends AbstractAction
{
    public function __construct()
    {
        $this->name = "Начать задание";
        $this->code = 1;
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
        return $executorId !== $customerId && $executorId === $activeId;
    }
}
