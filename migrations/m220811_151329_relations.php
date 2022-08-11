<?php

use yii\db\Migration;

/**
 * Class m220811_151329_relations
 */
class m220811_151329_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        // users table
        $this->addForeignKey("FK_users_cities", "users", "city_id", "cities", "id");
        $this->addForeignKey("FK_users_files", "users", "avatar_file_id", "files", "id");

        // reviews table
        $this->addForeignKey("FK_reviews_tasks", "reviews", "task_id", "tasks", "id");

        // tasks table
        $this->addForeignKey("FK_tasks_categories", "tasks", "category_id", "categories", "id");
        $this->addForeignKey("FK_tasks_cities", "tasks", "city_id", "cities", "id");
        $this->addForeignKey("FK_tasks_users_1", "tasks", "customer_id", "users", "id");
        $this->addForeignKey("FK_tasks_users_2", "tasks", "worker_id", "users", "id");

        // users_categories table
        $this->addForeignKey("FK_users_categories_users", "users_categories", "user_id", "users", "id");
        $this->addForeignKey("FK_users_categories_categories", "users_categories", "category_id", "categories", "id");

        // tasks_files table
        $this->addForeignKey("FK_tasks_files_tasks", "tasks_files", "task_id", "tasks", "id");
        $this->addForeignKey("FK_tasks_files_files", "tasks_files", "file_id", "files", "id");

        // responses table
        $this->addForeignKey("FK_responses_tasks", "responses", "task_id", "tasks", "id");
        $this->addForeignKey("FK_responses_users", "responses", "user_id", "users", "id");

        // categories table
        $this->addForeignKey("FK_categories_files", "categories", "file_id", "files", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // users table
        $this->dropForeignKey("FK_users_cities", "users");
        $this->dropForeignKey("FK_users_files", "users");

        // reviews table
        $this->dropForeignKey("FK_reviews_tasks", "reviews");

        // tasks table
        $this->dropForeignKey("FK_tasks_categories", "tasks");
        $this->dropForeignKey("FK_tasks_cities", "tasks");
        $this->dropForeignKey("FK_tasks_users_1", "tasks");
        $this->dropForeignKey("FK_tasks_users_2", "tasks");

        // users_categories table
        $this->dropForeignKey("FK_users_categories_users", "users_categories");
        $this->dropForeignKey("FK_users_categories_categories", "users_categories");

        // tasks_files table
        $this->dropForeignKey("FK_tasks_files_tasks", "tasks_files");
        $this->dropForeignKey("FK_tasks_files_files", "tasks_files");

        // responses table
        $this->dropForeignKey("FK_responses_tasks", "responses");
        $this->dropForeignKey("FK_responses_users", "responses");

        // categories table
        $this->dropForeignKey("FK_categories_files", "categories");
    }
}
