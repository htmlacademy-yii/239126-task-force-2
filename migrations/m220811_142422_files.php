<?php

use yii\db\Migration;

/**
 * Class m220811_142422_files
 */
class m220811_142422_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("files", [
            "id" => $this->primaryKey()->unsigned(),
            "path" => $this->string(500)->notNull(),
            "mime_type" => $this->string(255)->notNull()->defaultValue("")
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("files");
    }
}
