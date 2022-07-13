<?php

declare(strict_types=1);

namespace TaskForce\services;

use mysqli;
use RuntimeException;
use SplFileObject;
use TaskForce\exceptions\DatabaseStmtException;
use TaskForce\exceptions\FileFormatException;
use TaskForce\exceptions\SourceFileException;

abstract class AbstractFileImporter
{
    private string $filename;
    /**
     * @var array<string> $columns
     */
    private array $columns;
    private SplFileObject $fileObject;
    private string $separator;

   /**
     * @var array<string|mixed> $result
     */
    private array $result = [];

    /**
     * AbstractFileImporter constructor.
     * Дефолтным разделителем является запятая
     * @param string $filename
     * @param array<string> $columns
     * @param string $separator
     * @throws SourceFileException
     * @throws FileFormatException
     */
    public function __construct(string $filename, array $columns, string $separator = ",")
    {
        $this->filename = $filename;
        $this->columns = $columns;
        $this->separator = $separator;

        try {
            $this->fileObject = new SplFileObject($this->filename);
        } catch (RuntimeException $e) {
            throw new SourceFileException($e->getMessage());
        }

        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверно загаловки столбцов");
        }

        $headerData = $this->getHeaderData();

        if ($headerData !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }
    }

    /**
     * Импортиурет данный из csv файла в массив.
     * @return array<string|mixed>
     */
    protected function import(): array
    {
        foreach ($this->getNextLine() as $line) {
            if ($line !== null) {
                $this->result[] = $line;
            }
        }

        return $this->result;
    }

    /**
     * Возвращает данные о заголовках в csv файле
     * @return array<string|mixed>|null|bool
     */
    protected function getHeaderData(): array|null|bool
    {
        $this->fileObject->rewind();
        return $this->fileObject->fgetcsv();
    }

    /**
     * Итерируется по csv файлу и возвращает
     * порцию данных из таблицы
     * @return iterable<string|mixed>
     */
    private function getNextLine(): iterable
    {
        $this->fileObject->setFlags(SplFileObject::SKIP_EMPTY);
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv($this->separator);
        }
    }

    /**
     * Валидирует колонки csv файла
     * порцию данных из таблицы
     * @param array<string> $columns
     *
     * @return bool
     */
    private function validateColumns(array $columns): bool
    {
        if (count($columns) === 0) {
            return false;
        }

        foreach ($columns as $column) {
            if (!is_string($column)) {
                 return false;
            }
        }
        return true;
    }

    /**
     * Сохраняет csv файл в Базу данных
     * @param mysqli $con объект соединения с БД
     * @throws DatabaseStmtException
     * @throws SourceFileException
     * @throws FileFormatException
     */
    abstract public function saveCsvToDatabase(mysqli $con): void;
}
