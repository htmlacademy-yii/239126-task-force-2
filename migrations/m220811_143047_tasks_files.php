<?php

use yii\db\Migration;

/**
 * Class m220811_143047_tasks_files
 */
class m220811_143047_tasks_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("tasks_files", [
            "task_id" => $this->integer()->unsigned()->notNull(),
            "file_id" => $this->integer()->unsigned()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("tasks_files");
    }
}
