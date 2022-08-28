<?php
/*foreach ($tasks as $task) {
            print_r($task->id);
            print_r("</br>");
            print_r($task->name);
            print_r("</br>");
            print_r($task->description);
            print_r("</br>");
            print_r($task->category->name);
            print_r("</br>");
            print_r($task->city->name);
            print_r("</br>");
            print_r($task->price);
            print_r("</br>");
            print_r($task->start_date);
            print_r("</br>");
            print_r($task->expiration_date);
            print_r("</br>");
            print_r($task->customer->name);
            print_r("</br>");

            print_r("</br>");
            print_r("</br>");
        }
*/
?>

<?php
/**
 * @var $tasks array
 */

    $now = new DateTime();
?>

<div class="left-column">
     <h3 class="head-main head-task">Новые задания</h3>
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
</div>
