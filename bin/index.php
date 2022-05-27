<?php

require_once __DIR__ . "/../vendor/autoload.php";

use TaskForce\models\Task;

$res1 = new Task(customerId: 1, executorId: 2);

print_r($res1->getActionsList());

print_r($res1->getStatusesList());
