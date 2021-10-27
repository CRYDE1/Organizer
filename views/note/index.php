<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Note';
?>
<div class="site-index">
    <?php if (!empty($notes)): ?>
        <h2>Заметки</h2>
        <?php foreach ($notes as $noteIndex => $note): ?>
            <div class="card task">
                <div class="taskHeader noteHeader">
                    <div class="taskControl">
                        <div class="taskControl taskMainControl">
                            <?= '<a href="?update=' . $note['id'] . '" title="Редактировать заметку"><img src="' . Url::base() . '/images/Edit.svg" alt="Edit"></a>' ?>
                            <?= '<a href="?delete=' . $note['id'] . '" title="Удалить заметку"><img src="' . Url::base() . '/images/Delete.svg" alt="Delete"></a>' ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $note['text'] ?></p>
                </div>
            </div>
            <?php
            if (!empty($_GET['update'])) {
                if ($_GET['update'] == $note['id']) {
                    $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'text')->label('Текст') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end();
                }
            } ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php
    echo '<a href="?add_note=1" class="link"><img src="' . Url::base() . '/images/Plus.svg" alt="Plus"> Добавить заметку</a>' ?>
    <?php if (!empty($_GET['add_note'])) {
        $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'text')->label('Текст') ?>
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end();
    } ?>
</div>