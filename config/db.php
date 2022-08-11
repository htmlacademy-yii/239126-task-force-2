<?php

$con = require __DIR__ . "/../config.php";


$db = $con["db"];

$hostname = $db["host"];
$dbName = $db["database"];
$userName = $db["user"];
$password = $db["password"];

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host=" . $hostname  . ";dbname=" . $dbName,
    'username' => $userName,
    'password' => $password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
