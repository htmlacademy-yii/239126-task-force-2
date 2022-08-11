<?php

use yii\db\Migration;

/**
 * Class m220811_141501_users_categories
 */
class m220811_141501_users_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("users_categories", [
            "id" => $this->primaryKey()->unsigned(),
            "user_id" => $this->integer()->unsigned()->notNull(),
            "category_id" => $this->integer()->unsigned()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("users_categories");
    }
}
