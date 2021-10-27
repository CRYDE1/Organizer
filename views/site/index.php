<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <a href=""></a>
    <?php  if(!empty($tasks) && !empty($tasksTitle)):  ?>
    <h2><?= $tasksTitle ?></h2>
    <?php foreach ($tasks as $taskIndex => $task): ?>
    <div>
        <h3><?= $task['title'] ?></h3>
        <p><?= $task['date'] ?></p>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>