<?php

use TaskForce\services\CitiesImporter;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m220824_142707_cities_data_insertion
 */
class m220824_142707_cities_data_insertion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $importer = new CitiesImporter(__DIR__ . "/../data/cities-point.csv", ["name", "point"], ";");
        } catch (Exception $e) {
            print_r($e->getMessage());
            exit(1);
        }

        $data = $importer->import();

        foreach ($data as $row) {
            $coordinates = new Expression("ST_GeomFromText(:point)", [
                ":point" => $row[1]
            ]);
            $this->insert("cities", [
                "name" => $row[0],
                "position" => $coordinates
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
