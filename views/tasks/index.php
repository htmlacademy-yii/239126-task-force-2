<?php

/**
 * @var array $tasks
 * @var SearchTaskForm $searchTaskFormModel
 * @var array $categories
 */

use app\models\SearchTaskForm;
use yii\widgets\ActiveForm;

    $now = new DateTime();
?>

<div class="left-column">
     <h3 class="head-main head-task">Новые задания</h3>
    <?php if (count($tasks)) : ?>
        <?php foreach ($tasks as $task) : ?>
            <div class="task-card">
                <div class="header-task">
                    <a  href="#" class="link link--block link--big"><?= $task->name ?></a>
                    <p class="price price--task"><?= $task->price ?> ₽</p>
                </div>
                <?php
                    $taskDateTime = new DateTime($task->start_date);
                    $diff = $taskDateTime->diff($now);
                    $hours = $diff->h;
                ?>
                <p class="info-text"><span class="current-time"><?= $hours ?> часа </span>назад</p>
                <p class="task-text">
                    <?= $task->description ?>
                </p>
                <div class="footer-task">
                    <p class="info-text town-text"><?= $task->city->name ?></p>
                    <p class="info-text category-text"><?= $task->category->name ?></p>
                    <a href="#" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Нет новых задач</p>
    <?php endif; ?>
</div>

<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php $form = ActiveForm::begin(
                ['method' => 'get', 'action' => ['']]
            ); ?>
           <h4 class="head-card">Категории</h4>
           <?= $form
               ->field(
                   $searchTaskFormModel,
                   "categories",
                   [
                       "template" => "{input}",
                       "options" => ["class" => "form-group"],
                   ]
               )
               ->checkboxList(
                   $categories,
                   [
                       "class" => "checkbox-wrapper",
                       "itemOptions" => [
                               "labelOptions" => ["class" => "control-label"],
                       ]
                   ]
               );
            ?>

            <h4 class="head-card">Дополнительно</h4>

            <?= $form
                ->field(
                    $searchTaskFormModel,
                    "withoutExecutor",
                    [
                        "template" => "{input}",
                    ]
                )
                ->checkbox(
                    [
                        "labelOptions" => ["class" => "control-label"],
                    ]
                );
            ?>

            <?= $form
                ->field(
                    $searchTaskFormModel,
                    "hoursInterval",
                    [
                        "template" => "{input}",
                        "options" => ["class" => "form-group"],
                    ]
                )
                ->dropDownList(
                    [
                        "1" => "1 час",
                        "12" => "12 часов",
                        "24" => "24 часа",
                    ]
                );
            ?>

            <input type="submit" class="button button--blue" value="Искать">
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
