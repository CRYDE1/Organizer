<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Contact';
?>
<div class="site-index">
    <?php if (!empty($contacts)): ?>
        <h2>Контакты</h2>
        <?php foreach ($contacts as $contactIndex => $contact): ?>
            <div class="card task">
                <div class="taskHeader">
                    <?= $contact['fio'] ?>
                    <div class="taskControl">
                        <div class="taskControl taskMainControl">
                            <?= '<a href="?update=' . $contact['id'] . '" title="Редактировать контакт"><img src="' . Url::base() . '/images/Edit.svg" alt="Edit"></a>' ?>
                            <?= '<a href="?delete=' . $contact['id'] . '" title="Удалить контакт"><img src="' . Url::base() . '/images/Delete.svg" alt="Delete"></a>' ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($contact['phone'] !== null) echo '<p class="card-text taskInc&Exp">Телефон: ' . $contact['phone'] . '</p>' ?>
                    <?php if ($contact['address'] !== null) echo '<p class="card-text taskInc&Exp">Адрес: ' . $contact['address'] . '</p>' ?>
                    <?php if ($contact['email'] !== null) echo '<p class="card-text taskInc&Exp">Email: ' . $contact['email'] . '</p>' ?>
                </div>
            </div>
        <?php
            if (!empty($_GET['update'])) {
            if ($_GET['update'] == $contact['id']) {
            $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'fio')->label('ФИО') ?>
                <?= $form->field($model, 'phone')->label('Телефон') ?>
                <?= $form->field($model, 'address')->label('Адрес') ?>
                <?= $form->field($model, 'email')->label('Email') ?>
            <div class="form-group">
                <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end();
        }
        } ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo '<a href="?add_contact=1" class="link"><img src="' . Url::base() . '/images/Plus.svg" alt="Plus"> Добавить контакт</a>' ?>
    <?php if (!empty($_GET['add_contact'])) {
        $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'fio')->label('ФИО') ?>
        <?= $form->field($model, 'phone')->label('Телефон') ?>
        <?= $form->field($model, 'address')->label('Адрес') ?>
        <?= $form->field($model, 'email')->label('Email') ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end();
    } ?>
</div>