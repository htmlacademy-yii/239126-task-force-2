<?php

require_once __DIR__ . "/../vendor/autoload.php";

use TaskForce\connectors\Database;
use TaskForce\models\Task;
use TaskForce\services\CategoriesImporter;
use TaskForce\services\CitiesImporter;

$res1 = new Task(customerId: 1, executorId: 2);

print_r($res1->getActionsList());

print_r($res1->getStatusesList());

$config = require_once __DIR__ . "config.php";

$con = Database::connect($config["db"]);

$res2 = new CategoriesImporter(__DIR__ . "data/categories.csv", ["name", "icon"], ",");

$res3 = new CitiesImporter(__DIR__ . "data/cities-point.csv", ["name", "point"], ";");

$res3->saveCsvToDatabase($con);
