<?php

declare(strict_types=1);

namespace TaskForce\models\actions;

class ActionFinish extends AbstractAction
{
    public function __construct()
    {
        $this->name = "Выполнено";
        $this->code = 4;
    }

    /**
     * Метод проверки прав
     * Возвращает true в случае если текущий пользователь
     * является заказчиком задания
     * @param int $executorId -- id исполнителя задания
     * @param int $customerId -- id заказчика задания
     * @param int $activeId -- id текущего пользователя
     * @return bool
     */
    public function checkPermission(int $executorId, int $customerId, int $activeId): bool
    {
        return $executorId !== $customerId && $customerId === $activeId;
    }
}
