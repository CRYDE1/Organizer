<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="site-login">

    <h1>Регистрация</h1>
    <p>Пожалуйста, заполните следующие поля для регистрации</p>
    <!--    --><?php //$form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',

        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput()->hint('Пожалуйста, введите имя')->label('Имя пользователя') ?>
    <br>
    <?= $form->field($model, 'password')->passwordInput()->hint('Пожалуйста, введите пароль')->label('Пароль') ?>

    <div class="form-group register_button2">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary','style' => 'border-color: #40D082;color: black;background-color: #40D082;']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="register_button">
        Уже есть аккаунт?
        <a class="" href="login">Войти в аккаунт</a>
    </div>
</div>
