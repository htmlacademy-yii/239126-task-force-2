<?php

use yii\db\Migration;

/**
 * Class m220811_131655_reviews
 */
class m220811_131655_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("reviews", [
            "id" => $this->primaryKey()->unsigned(),
            "description" => $this->string(255)->notNull(),
            "creation_time" => $this->dateTime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            "grade" => $this->tinyInteger()->unsigned()->notNull(),
            "task_id" => $this->integer()->unsigned()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("reviews");
    }
}
