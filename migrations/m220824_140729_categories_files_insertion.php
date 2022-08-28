<?php

use TaskForce\services\CategoriesImporter;
use yii\db\Migration;

/**
 * Class m220824_140729_categories_files_insertion
 */
class m220824_140729_categories_files_insertion extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        try {
            $importer = new CategoriesImporter(__DIR__ . "/../data/categories.csv", ["name", "icon"], ",");
        } catch (Exception $e) {
            print($e->getMessage());
            exit(-1);
        }

        $data = $importer->import();

        foreach ($data as $row) {
            $this->insert("files", [
                "path" => $row[1]
            ]);

            $this->insert("categories", [
                "name" => $row[0],
                "file_id" => Yii::$app->db->getLastInsertID()
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
