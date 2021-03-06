<?php

declare(strict_types=1);

namespace TaskForce\models;

use TaskForce\exceptions\TaskInvalidActionException;
use TaskForce\exceptions\TaskInvalidStatusException;
use TaskForce\exceptions\TaskExecutorException;

/**
 * Модель задачи проекта
 */
class Task
{
    public const STATUS_NEW = 1;
    public const STATUS_CANCELLED = 2;
    public const STATUS_WORK_IN_PROGRESS = 3;
    public const STATUS_FINISHED = 4;
    public const STATUS_FAILED = 5;

    public const ACTION_BEGIN = 1;
    public const ACTION_CANCEL = 2;
    public const ACTION_RESPOND = 3;
    public const ACTION_FINISHED = 4;
    public const ACTION_DENIED = 5;

    private const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_CANCELLED,
        self::STATUS_WORK_IN_PROGRESS,
        self::STATUS_FINISHED,
        self::STATUS_FAILED
    ];

    private const STATUSES_WITH_EXECUTOR = [
        self::STATUS_WORK_IN_PROGRESS,
        self::STATUS_FINISHED,
        self::STATUS_FAILED
    ];

    private const ACTION_STATUS_MAP = [
        self::ACTION_BEGIN => self::STATUS_WORK_IN_PROGRESS,
        self::ACTION_CANCEL => self::STATUS_CANCELLED,
        self::ACTION_RESPOND => self::STATUS_NEW,
        self::ACTION_FINISHED => self::STATUS_FINISHED,
        self::ACTION_DENIED => self::STATUS_FAILED
    ];

    private const STATUS_RUS_NAMES_MAP = [
        self::STATUS_NEW => "Новое",
        self::STATUS_CANCELLED => "Отменено",
        self::STATUS_WORK_IN_PROGRESS => "В работе",
        self::STATUS_FINISHED => "Выполнено",
        self::STATUS_FAILED => "Провалено"
    ];

    private const ACTION_RUS_NAMES_MAP = [
        self::ACTION_BEGIN => "Начать задание",
        self::ACTION_CANCEL => "Отменить",
        self::ACTION_RESPOND => "Откликнуться",
        self::ACTION_FINISHED => "Выполнено",
        self::ACTION_DENIED => "Отказаться"
    ];
    private int $status;
    private int $customerId;
    private ?int $executorId;

    /**
    * Конструктор класса Task принимат $customerId - айди заказчика, $executorId - айди исполнителя
    * $status - по дефолту устанавливается как STATUS_NEW
    * @param int $customerId
    * @param int|null $executorId
    * @param int $status
    * @return void
    *
    * @throws TaskInvalidStatusException исключение для неверного статуса
    * @throws TaskExecutorException исключение для статусов в работе, провалена и завершена,
    * когда в конструктор исполнитель передан как null
    */
    public function __construct(int $customerId, ?int $executorId = null, int $status = self::STATUS_NEW)
    {
        $this->customerId = $customerId;
        $this->executorId = $executorId;

        if (!in_array($status, self::STATUSES)) {
            throw new TaskInvalidStatusException("Неверный статус");
        }

        if ($executorId === null && in_array($status, self::STATUSES_WITH_EXECUTOR)) {
            throw new TaskExecutorException("Для данного статуса обязательно нужен исполнитель");
        }

        $this->status = $status;
    }

    /**
     * Метод возвращает массив имен на русском всех статусов
     * @return array<int, string>
     */
    public function getStatusesList(): array
    {
        return self::STATUS_RUS_NAMES_MAP;
    }

    /**
     * Метод возвращает массив имен на русском всех действий
     * @return array<int, string>
     */
    public function getActionsList(): array
    {
        return self::ACTION_RUS_NAMES_MAP;
    }

    /**
     * Метод принимает константу $action и возвращает следующий допустимый статус или null
     * @param int $action
     * @return int
     *
     * @throws TaskInvalidActionException исключение срабатывает при передачи несуществующего
     * действия в метод
     */
    public function getNextStatus(int $action): int
    {
        if (!array_key_exists($action, self::ACTION_STATUS_MAP)) {
            throw new TaskInvalidActionException("Неверное действие");
        }

        return self::ACTION_STATUS_MAP[$action];
    }

    /**
     * Метод принимает id текущего пользователя и возвращает массив возможных действий в
     * завсимости от роли пользователя
     * @param int $currentUserId
     * @return array<int>
     */
    public function getAvailableActions(int $currentUserId): array
    {
        if ($currentUserId === $this->customerId) {
            if ($this->status === self::STATUS_NEW) {
                return [self::ACTION_BEGIN, self::ACTION_CANCEL];
            }

            if ($this->status === self::STATUS_WORK_IN_PROGRESS) {
                return [self::ACTION_FINISHED];
            }
        }

        if ($currentUserId !== $this->executorId && $currentUserId !== $this->customerId) {
            if ($this->status === self::STATUS_NEW) {
                return [self::ACTION_RESPOND];
            }
        }

        if ($currentUserId === $this->executorId) {
            if ($this->status === self::STATUS_WORK_IN_PROGRESS) {
                return [self::ACTION_DENIED];
            }
        }

        return [];
    }
}
