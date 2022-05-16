<?php

/**
 * Модель задачи проекта
 */
class Task
{
    // TODO: поменять тип констант на целочечисленные
    const STATUS_NEW = "new";
    const STATUS_CANCELLED = "cancelled";
    const STATUS_WORK_IN_PROGRESS = "work in progress";
    const STATUS_FINISHED = "finished";
    const STATUS_FAILED = "failed";

    // TODO: добавить константы значений целочисленными
    private string $status;
    private int $customerId;
    private int $executorId;
    // TODO: добавить русские названия для действий
    // TODO: передать текущий статус задачи
    function __construct(int $customerId, int $executorId)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;
        $this->status = self::STATUS_NEW;
    }

    public function getNextStatus(string $action): ?string
    {

    }

    public function getAvailableActions(int $currentUserId): array
    {

    }

    public static function getFive(): int
    {
        return 5;
    }
}
