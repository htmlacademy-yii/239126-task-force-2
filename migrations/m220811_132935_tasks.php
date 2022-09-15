<?php

use yii\db\Migration;

/**
 * Class m220811_132935_tasks
 */
class m220811_132935_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("tasks", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(255)->notNull(),
            "description" => $this->text()->notNull(),
            "status" => "ENUM('new', 'cancelled', 'work_in_progress', 'finished', 'failed') DEFAULT 'new'",
            "category_id" => $this->integer()->unsigned()->notNull(),
            "city_id" => $this->integer()->unsigned()->notNull(),
            "price" => $this->decimal(10, 2)->unsigned()->notNull(),
            "start_date" => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP",
            "expiration_date" => $this->dateTime()->notNull(),
            "customer_id" => $this->integer()->unsigned(),
            "worker_id" => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("tasks");
    }
}
