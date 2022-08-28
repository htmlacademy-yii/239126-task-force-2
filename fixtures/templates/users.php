<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    "name" => $faker->name . $faker->lastName,
    "email" => $faker->email,
    "password" => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    "phone" => substr($faker->e164PhoneNumber, 1, 11),
    "telegram" => $faker->userName,
    "birthday" => $faker->date,
    "about" => $faker->text(50),
    "city_id" => $faker->numberBetween(1, 500),
];