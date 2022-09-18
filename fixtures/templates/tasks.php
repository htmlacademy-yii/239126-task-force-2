<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

return [
    "name" => $faker->word,
    "description" => $faker->text,
    "category_id" => $faker->numberBetween(1, 8),
    "city_id" => $faker->numberBetween(1, 500),
    "price" => $faker->randomNumber(5),
    "expiration_date" => $faker->dateTimeBetween($startDate = "now", $endDate = "+1 years")->format("Y-m-d"),
    "customer_id" => $faker->numberBetween(1, 10)
];