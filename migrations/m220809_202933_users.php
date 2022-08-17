<?php

use yii\db\Migration;

/**
 * Class m220809_202933_users
 */
class m220809_202933_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable("users", [
            "id" => $this->primaryKey()->unsigned(),
            "name" => $this->string(128)->notNull(),
            "email" => $this->string(255)->notNull()->unique(),
            "password" => $this->string(60)->notNull(),
            "creation_time" => $this->dateTime()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            "phone" => $this->string(20)->unique(),
            "telegram" => $this->string(128)->unique(),
            "birthday" => $this->date(),
            "about" => "TEXT",
            "city_id" => $this->integer()->unsigned()->notNull(),
            "avatar_file_id" => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable("users");
    }
}
