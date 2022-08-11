<?php

use yii\db\Migration;

/**
 * Class m220811_143605_responses
 */
class m220811_143605_responses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("responses", [
            "id" => $this->primaryKey()->unsigned(),
            "message" => $this->string(255)->defaultValue(""),
            "price" => $this->decimal(10, 2)->notNull(),
            "creation_time" => $this->dateTime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            "task_id" => $this->integer()->unsigned()->notNull(),
            "user_id" => $this->integer()->unsigned()->notNull(),
            "is_declined" => $this->boolean()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("responses");
    }
}
