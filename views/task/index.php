<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Task';
?>
<div class="site-index">
    <?php if (!empty($_POST['selectTask'])) print_r($_POST['selectTask']) ?>
    <?php if (!empty($tasksTitle)) echo '<h2>' . $tasksTitle . '</h2>' ?>
    <?php if (!empty($tasks)): ?>
        <?= '<a class="btn btn-primary" style="border-color: #40D082;color: black;background-color: #40D082;" href="?t=' . $_GET['t'] . '&select=1">Сгруппировать</a>' ?>
        <?= '<a class="btn btn-primary" style="border-color: #40D082;color: black;background-color: #40D082; margin-top: 10px" href="?t=' . $_GET['t'] . '&sortBy=priority">Сортировка по приоритету</a>' ?>
        <?php if ($_GET['t'] !== 'all' && $_GET['t'] !== 'today' && $_GET['t'] !== 'prev') echo '<a href="?t=' . $_GET['t'] . '&deleteGroup=' . $tasks[0]['group_id'] . '">Удалить</a>' ?>
        <?php if (!empty($_GET['select'])) echo '<a class="btn btn-primary" style="border-color: #40D082;color: black;background-color: #40D082; margin-top: 10px" href="?t=' . $_GET['t'] . '">Отмена</a>' ?>
        <?php if (!empty($_GET['select'])) echo '<form method="post" class="taskForm" style="margin-top: 10px">' ?>
        <?php if (!empty($_GET['select'])) echo '<input type="text" name="nameGroup" placeholder="Название группы">' ?>
        <?php foreach ($tasks as $taskIndex => $task): ?>
            <?php if (!empty($_GET['select'])) echo '<input type="checkbox" name="selectTask[]" value="' . $task['id'] . '">' ?>
            <div class="card task">
                <div class="taskHeader">
                    <?= $task['title'] ?>
                    <?php
                    if (!empty($task['file'])) {
                        echo '<a href="/files/' . $task['user_id'] . '_' . $task['file'] . '" title="Прикрепленный файл">' . $task['file'] . '</a>' .
                            '<a href="?t=' . $_GET['t'] . '&deleteFile=' . $task['id'] . '" title="Удалить файл"><img src="' . Url::base() . '/images/Paper Fail.svg" alt="Delete File"></a>';
                    }
                    ?>
                    <div class="taskControl">
                        <?= '<a href="?t=' . $_GET['t'] . '&inc_exp=' . $task['id'] . '" title="Доходы и расходы"><img src="' . Url::base() . '/images/Wallet.svg" alt="Wallet"></a>' ?>
                        <?php if (empty($task['file'])) echo '<a href="?t=' . $_GET['t'] . '&file=' . $task['id'] . '" title="Прикрепить файл"><img src="' . Url::base() . '/images/Paper Plus.svg" alt="File"></a>'; ?>
                        <?= '<a href="?t=' . $_GET['t'] . '&priority=' . $task['id'] . '" title="Приоритет"><img src="' . Url::base() . '/images/Priority.svg" alt="Приоритет"></a>' ?>
                        <div class="taskControl taskMainControl">
                            <?= '<a href="?t=' . $_GET['t'] . '&update=' . $task['id'] . '" title="Редактировать задачу"><img src="' . Url::base() . '/images/Edit.svg" alt="Edit"></a>' ?>
                            <?= '<a href="?t=' . $_GET['t'] . '&delete=' . $task['id'] . '" title="Удалить задачу"><img src="' . Url::base() . '/images/Delete.svg" alt="Delete"></a>' ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($task['description'] !== null) echo '<p class="card-text">' . $task['description'] . '</p>'; ?>
                    <?php if ($task['income'] !== null) echo '<p class="card-text taskInc&Exp">Доходы: ' . $task['income'] . '</p>' ?>
                    <?php if ($task['expense'] !== null) echo '<p class="card-text taskInc&Exp">Расходы: ' . $task['expense'] . '</p>' ?>
                    <p class="card-text taskDate">Дата: <?= $task['date'] ?></p>
                </div>
            </div>
            <?php
            if (!empty($_GET['file'])) {
                if ($_GET['file'] === $task['id']) {
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'file')->fileInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Прикрепить', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end();
                }
            } ?>
            <?php
            if (!empty($_GET['priority'])) {
                if ($_GET['priority'] === $task['id']) {
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'priority')->label('Приоритет') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Установить приоритет', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end();
                }
            } ?>
            <?php
            if (!empty($_GET['update'])) {
                if ($_GET['update'] === $task['id']) {
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'title')->label('Название') ?>
                    <?= $form->field($model, 'description')->label('Описание') ?>
                    <?= $form->field($model, 'date')->textInput(['type' => 'date'])->label('Дата'); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end();
                }
            } ?>
            <?php
            if (!empty($_GET['inc_exp'])) {
                if ($_GET['inc_exp'] === $task['id']) {
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'income')->label('Доходы') ?>
                    <?= $form->field($model, 'expense')->label('Расходы') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end();
                }
            } ?>
        <?php endforeach; ?>
        <?php if (!empty($_GET['select'])) echo '<input class="btn btn-primary" type="submit" value="Сгруппировать">' ?>
        <?php if (!empty($_GET['select'])) echo '</form>' ?>
    <?php endif; ?>
    <?php
    if (!empty($_GET['t']))
        echo '<a href="?t=' . $_GET['t'] . '&add_task=1" class="link"><img src="' . Url::base() . '/images/Plus.svg" alt="Plus"> Добавить задачу</a>' ?>
    <?php if (!empty($_GET['add_task'])) {
        $form = ActiveForm::begin(['options' => ['style' => 'margin-bottom: 80px;']]); ?>
        <?= $form->field($model, 'title')->label('Название') ?>
        <?= $form->field($model, 'description')->label('Описание') ?>
        <?= $form->field($model, 'date')->textInput(['type' => 'date'])->label('Дата'); ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end();
    } ?>
</div>