<?php

namespace app\controllers;

use app\models\Categories;
use app\models\SearchTaskForm;
use Yii;
use yii\web\Controller;
use app\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $searchTaskFormModel = new SearchTaskForm();
        $categories = Categories::find()->select("name")->indexBy("id")->column();

        $searchTaskFormModel->categories = $categories;
        if (Yii::$app->request->getIsGet()) {
            $searchTaskFormModel->load(Yii::$app->request->get());
        }

        $tasksQuery = Tasks::find()
                            ->with("category", "city")
                            ->where(["status" => "new"])
                            ->andWhere(["category_id" => $searchTaskFormModel->categories])
                            ->andWhere(
                                "`start_date` >= CURRENT_TIMESTAMP() - INTERVAL :period HOUR",
                                [":period" => $searchTaskFormModel->hoursInterval]
                            );

        if ($searchTaskFormModel->withoutExecutor) {
            $tasksQuery->andWhere(["worker_id" => null]);
        }

        $tasks = $tasksQuery->orderBy(["start_date" => SORT_DESC])->all();
        return $this->render("index", compact("tasks", "searchTaskFormModel", "categories"));
    }
}