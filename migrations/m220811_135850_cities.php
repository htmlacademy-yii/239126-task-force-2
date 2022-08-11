<?php

use yii\db\Migration;

/**
 * Class m220811_135850_cities
 */
class m220811_135850_cities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("cities", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(128)->notNull(),
            "position" => "POINT NOT NULL SRID 0"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("cities");
    }
}
