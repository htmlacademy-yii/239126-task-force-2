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
    "start_date" => $faker->date,
    "expiration_date" => $faker->date,
    "customer_id" => $faker->numberBetween(1, 10)
];