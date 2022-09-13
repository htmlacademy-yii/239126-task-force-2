<?php

namespace app\controllers;

use app\models\Categories;
use app\models\SearchTaskForm;
use yii\web\Controller;
use app\models\Tasks;
use yii\data\Sort;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find()->orderBy(["start_date" => SORT_DESC])->all();
        $searchTaskFormModel = new SearchTaskForm();
        $categories = Categories::find()->select("name")->column();

        return $this->render("index", compact("tasks", "searchTaskFormModel", "categories"));
    }
}