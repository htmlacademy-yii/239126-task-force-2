<?php

namespace Tests\unit\services;

use Exception;
use mysqli;
use PHPUnit\Framework\TestCase;
use TaskForce\connectors\Database;
use TaskForce\exceptions\FileFormatException;
use TaskForce\exceptions\SourceFileException;
use TaskForce\services\CategoriesImporter;

class CategoriesImporterTest extends TestCase
{
    private mysqli $con;

    public function setUp(): void
    {
        parent::setUp();

        $config = require __DIR__ . "/../../config-test.php";
        $db = $config["db"];
        try {
            $this->con = Database::connect($db);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testImportCsvToDb(): void
    {
        $categories = [];
        try {
            $importer = new CategoriesImporter(__DIR__ . "/../../data/services/categories.csv", ["name", "icon"]);

            $importer->saveCsvToDatabase($this->con);

            $res = $this->con->query(
                "SELECT c.name as name, f.path as path
                        FROM files as f
                        JOIN categories AS c ON c.file_id = f.id;"
            );

            if (is_object($res)) {
                foreach ($res as $row) {
                    $categories[] = $row;
                }
            }

            $categoriesDummy = [];
            $file = file_get_contents(__DIR__ . "/../../data/services/categories-dummy.json");
            if (is_string($file)) {
                $categoriesDummy = json_decode(
                    $file,
                    true
                );
            }

            $this->assertEquals($categoriesDummy, $categories);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function textExceptionConstructor(): void
    {
        try {
            new CategoriesImporter("..", ["name", "bla"], ",");
            $this->fail("SourceFileException was not thrown");
        } catch (SourceFileException $e) {
            $this->assertEquals($e->getMessage(), $e->getMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        try {
            new CategoriesImporter(__DIR__ . "/../../data/services/cities.csv", [], ";");
            $this->fail("FileFormatException was not thrown");
        } catch (FileFormatException $e) {
            $this->assertEquals("Заданы неверно загаловки столбцов", $e->getMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        try {
            new CategoriesImporter(__DIR__ . "/../../data/services/cities.csv", ["hahah", "bla bla"], ";");
            $this->fail("FileFormatException was not thrown");
        } catch (FileFormatException $e) {
            $this->assertEquals("Исходный файл не содержит необходимых столбцов", $e->getMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();

        mysqli_query($this->con, "SET foreign_key_checks = 0");
        mysqli_query($this->con, "TRUNCATE files");
        mysqli_query($this->con, "TRUNCATE categories");
        mysqli_query($this->con, "SET foreign_key_checks = 1");
    }
}
