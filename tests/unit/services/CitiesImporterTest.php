<?php

namespace Tests\unit\services;

use Exception;
use mysqli;
use PHPUnit\Framework\TestCase;
use TaskForce\connectors\Database;
use TaskForce\exceptions\FileFormatException;
use TaskForce\exceptions\SourceFileException;
use TaskForce\services\CitiesImporter;

class CitiesImporterTest extends TestCase
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
        $cities = [];
        try {
            $importer = new CitiesImporter(__DIR__ . "/../../data/services/cities.csv", ["name", "point"], ";");

            $importer->saveCsvToDatabase($this->con);

            $res = $this->con->query(
                "SELECT name, ST_X(position) as latitude,
                        ST_Y(position) as longitude FROM cities;"
            );

            if (is_object($res)) {
                foreach ($res as $row) {
                    $cities[] = $row;
                }
            }

            $citiesDummy = [];
            $file = file_get_contents(__DIR__ . "/../../data/services/cities-dummy.json");
            if (is_string($file)) {
                $citiesDummy = json_decode(
                    $file,
                    true
                );
            }

            $this->assertEquals($citiesDummy, $cities);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function textExceptionConstructor(): void
    {
        try {
            new CitiesImporter("..", ["name", "bla"], ",");
            $this->fail("SourceFileException was not thrown");
        } catch (SourceFileException $e) {
            $this->assertEquals($e->getMessage(), $e->getMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        try {
            new CitiesImporter(__DIR__ . "/../../data/services/cities.csv", [], ";");
            $this->fail("FileFormatException was not thrown");
        } catch (FileFormatException $e) {
            $this->assertEquals("Заданы неверно загаловки столбцов", $e->getMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }

        try {
            new CitiesImporter(__DIR__ . "/../../data/services/cities.csv", ["hahah", "bla bla"], ";");
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
        mysqli_query($this->con, "TRUNCATE cities");
        mysqli_query($this->con, "SET foreign_key_checks = 1");
    }
}
