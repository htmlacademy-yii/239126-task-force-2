<?php

declare(strict_types=1);

namespace TaskForce\services;

use mysqli;
use TaskForce\connectors\Database;
use TaskForce\exceptions\DatabaseStmtException;

class CategoriesImporter extends AbstractFileImporter
{

    public function saveCsvToDatabase(mysqli $con): void
    {
        $data = $this->import();

        foreach ($data as $row) {
            $query = "INSERT INTO files(path)  VALUES(?)";
            $stmt = Database::getPreparedStmt($con, $query, ["file_id" => $row[1]]);

            if (!mysqli_stmt_execute($stmt)) {
                throw new DatabaseStmtException(mysqli_error($con));
            }

            $query = "INSERT INTO categories(name, file_id) VALUES(?, LAST_INSERT_ID());";

            $stmt = Database::getPreparedStmt($con, $query, ["name" => $row[0]]);

            if (!mysqli_stmt_execute($stmt)) {
                throw new DatabaseStmtException(mysqli_error($con));
            }
        }
    }
}
