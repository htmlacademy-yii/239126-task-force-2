<?php

declare(strict_types=1);

namespace TaskForce\connectors;

use mysqli;
use TaskForce\exceptions\DatabaseConnectException;

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
}
