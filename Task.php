<?php

class Task
{
    const STATUS_NEW = "new";
    const STATUS_CANCELLED = "cancelled";
    const STATUS_WORK_IN_PROGRESS = "work in progress";
    const STATUS_FINISHED = "finished";
    const STATUS_FAILED = "failed";

    private string $currentStatus;
    private string $taskName;
    private int $customerID;
    private int $performerID;

    function __construct(int $customerID, int $performerID, string $taskName)
    {
        $this->customerID = $customerID;
        $this->performerID = $performerID;
        $this->currentStatus = self::STATUS_NEW;
        $this->taskName = $taskName;
    }

    public function getNextStatus(string $action): ?string
    {

    }

    public function getAvailableActions(): string
    {

    }
}
