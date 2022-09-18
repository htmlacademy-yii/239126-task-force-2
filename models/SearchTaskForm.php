<?php

namespace app\models;

use yii\base\Model;

class SearchTaskForm extends Model
{
    public string|array $categories = "";
    public int $hoursInterval = 1;
    public bool $withoutExecutor = true;

    /**
     * {@inheritdoc}
     */
    public function formName(): string
    {
        return "";
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string>
     */
    public function attributeLabels(): array
    {
        return [
            "categories" => "Категории",
            "hoursInterval" => "Период",
            "withoutExecutor" => "Без исполнителя"
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    "categories",
                    "hoursInterval",
                    "withoutExecutor",
                ],
                "safe"
            ]
        ];
    }
}
