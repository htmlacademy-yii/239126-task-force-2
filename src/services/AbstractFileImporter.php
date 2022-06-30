<?php

declare(strict_types=1);

namespace TaskForce\services;

use RuntimeException;
use SplFileObject;
use TaskForce\exceptions\FileFormatException;
use TaskForce\exceptions\SourceFileException;

abstract class AbstractFileImporter
{
    private string $filename;
    private array $columns;
    private SplFileObject $fileObject;

    private array $result = [];

    /**
     * AbstractFileImporter constructor.
     * @param string $filename
     * @param array<string> $columns
     */
    public function __construct(string $filename, array $columns)
    {
        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function import(): void
    {
        if ($this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверно загаловки столбцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        } catch (RuntimeException $e) {
            throw new SourceFileException($e->getMessage());
        }

        $headerData = $this->getHeaderData();

        if ($headerData !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        foreach ($this->getNextLIne() as $line) {
            $this->result[] = $line;
        }
    }

    public function getHeaderData(): ?array
    {
        $this->fileObject->rewind();
        return $this->fileObject->fgetcsv();
    }

    private function getNextLIne(): ?iterable
    {
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }

        return null;
    }

    private function validateColumns(array $columns): bool
    {
        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    return false;
                }
            }
        } else {
            return false;
        }

        return true;
    }
}
