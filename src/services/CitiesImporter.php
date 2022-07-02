<?php

declare(strict_types=1);

namespace TaskForce\services;

use mysqli;
use TaskForce\connectors\Database;
use TaskForce\exceptions\DatabaseStmtException;

class CitiesImporter extends AbstractFileImporter
{
    public function saveCsvToDatabase(mysqli $con): void
    {
        $data = $this->import();

        foreach ($data as $row) {
            $query = "INSERT INTO cities(name, position) VALUES (?, ST_GeomFromText(?));";
            $stmt = Database::getPreparedStmt($con, $query, ["name" => $row[0], "point" => $row[1]]);

            if (!mysqli_stmt_execute($stmt)) {
                throw new DatabaseStmtException(mysqli_error($con));
            }
        }
    }
}
