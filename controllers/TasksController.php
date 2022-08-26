<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Tasks;
use yii\data\Sort;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find()->orderBy(["start_date" => SORT_DESC])->all();

        return $this->render("index", compact("tasks"));
    }
}