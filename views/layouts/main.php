<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1D1D1D;">
        <div class="container-fluid">
            <a class="navbar-brand"
               href="/web/task?t=today"><?= '<img src="' . Url::base() . '/images/Logo.svg" class="logo" alt="Logo">' ?>
                Organizer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                           href="/web/task?t=today"><?= '<img src="' . Url::base() . '/images/Work.svg" class="logo" alt="Задачи">' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="/web/note"><?= '<img src="' . Url::base() . '/images/Document.svg" class="logo" alt="Заметки">' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="/web/contact"><?= '<img src="' . Url::base() . '/images/3 User.svg" class="logo" alt="Контакты">' ?></a>
                    </li>
                </ul>
            </div>
            <div id="profile">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (Yii::$app->user->isGuest)
                            echo '<a class="nav-link" href="/web/site/login"><img src="' . Url::base() . '/images/Profile.svg" class="logo" alt="Профиль"></a>';
                        else echo '<a>'
                            . Html::beginForm(['site/logout'], 'post')
                            . Html::submitButton(
                                '<img src="' . Url::base() . '/images/Logout.svg" class="logo" alt="Logout">',
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</a>';
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?php $this->beginBody() ?>
<div class="main">
    <?php if (Url::current() !== '/web/site/login' && Url::current() !== '/web/site/register') {
        echo '<div class="group">
        <ul>
            <li><a href="/web/task?t=all"
                   class="groupButton"><img src = "' . Url::base() . '/images/Category.svg" alt = "All"> Все</a>
            </li>
            <li><a href="/web/task?t=today"
                   class="groupButton"><img src = "' . Url::base() . '/images/TimeCircle.svg" alt = "All" >
                    Сегодня</a></li>
            <li><a href="/web/task?t=prev"
                   class="groupButton"><img src = "' . Url::base() . '/images/Calendar.svg" alt = "All" >
                    Прошедшее</a></li>
            Группы';
        echo \app\widgets\GroupWidget::widget();
        echo '</ul></div>';
    }
    ?>
    <div class="container2">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
<footer>
    <nav class="navbar navbar-expand-lg navbar-dark"
         style="background-color: #1D1D1D;position: fixed;width: 100%;left: 0;bottom: 0;">
        <div class="container-fluid">
            <a class="navbar-brand"
               href="#"><?= '<img src="' . Url::base() . '/images/Logo.svg" class="logo" alt="Logo">' ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="footerNav">
                <ul class="navbar-nav" id="nav1">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/web/task?t=today">Задачи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/web/note">Заметки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/web/contact">Контакты</a>
                    </li>
                </ul>
                <ul class="navbar-nav" id="nav2">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">О нас</a>
                    </li>
                </ul>
                <ul class="navbar-nav" id="nav3">
                    <li class="nav-item nav-link active">
                        Мы в соц. сетях:
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="#"><?= '<img src="' . Url::base() . '/images/social/vk.svg" class="socialImg" alt="VK">' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="#"><?= '<img src="' . Url::base() . '/images/social/Facebook.svg" class="socialImg" alt="Facebook">' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="#"><?= '<img src="' . Url::base() . '/images/social/Telegram.svg" class="socialImg" alt="Telegram">' ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="#"><?= '<img src="' . Url::base() . '/images/social/Twitter.svg" class="socialImg" alt="Twitter">' ?></a>
                    </li>
                </ul>
                <ul class="navbar-nav" id="nav2">
                    <li class="nav-item nav-link active">
                        @ 2021 «Organizer.com»
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>
