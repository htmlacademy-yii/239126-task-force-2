<?php

declare(strict_types=1);

namespace TaskForce\connectors;

use mysqli;
use mysqli_stmt;
use TaskForce\exceptions\DatabaseConnectException;
use TaskForce\exceptions\DatabaseStmtException;

abstract class Database
{
    /**
     * Возвращает результат подключения к базе данных
     * @param array<string|null> $db - ассоциативный массив
     * с конфигом для подключения к базе данных
     * @return mysqli - объект подключения к БД
     * @throws DatabaseConnectException - ошибка подключения к бд
     */
    public static function connect(array $db): mysqli
    {
        $con = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);

        if ($con === false) {
            $error = mysqli_connect_error();
            throw new DatabaseConnectException(($error) ?: "Неизвестная ошибка");
        }

        mysqli_set_charset($con, "utf8");

        return $con;
    }

    /**
     * Создает подготовленное выражение на
     * основе готового SQL запроса и переданных данных
     *
     * @param mysqli $con Ресурс соединения
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array<mixed|string> $data Данные для вставки на место плейсхолдеров
     *
     * @return mysqli_stmt Подготовленное выражение
     * @throws DatabaseStmtException при работе с подготовленным выражением
     */
    public static function getPreparedStmt(mysqli $con, string $sql, array $data): mysqli_stmt
    {
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt === false) {
            $errorMsg = 'Не удалось инициализировать'
                . 'подготовленное выражение: ' . mysqli_error($con);
            throw new DatabaseStmtException($errorMsg);
        }

        if ($data) {
            $types = '';
            $stmtData = [];

            foreach ($data as $value) {
                $type = 's';

                if (is_int($value)) {
                    $type = 'i';
                } elseif (is_string($value)) {
                    $type = 's';
                } elseif (is_double($value)) {
                    $type = 'd';
                }

                $types .= $type;
                $stmtData[] = $value;
            }

            $values = array_merge([$stmt, $types], $stmtData);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);

            if (mysqli_errno($con) > 0) {
                $errorMsg = 'Не удалось связать подготовленное'
                    . 'выражение с параметрами: ' . mysqli_error($con);
                throw new DatabaseStmtException($errorMsg);
            }
        }

        return $stmt;
    }
}
