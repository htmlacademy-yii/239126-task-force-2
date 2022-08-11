<?php

use yii\db\Migration;

/**
 * Class m220811_140747_categories
 */
class m220811_140747_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("categories", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(128)->notNull(),
            "file_id" => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("categories");
    }
}
