<?php

/* @var $this yii\web\View */


use app\models\User;


$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тестовое задание!</h1>
        <hr>
        <h2 class="h2">Вы на главной странице сайта</h2>

        <?php if(Yii::$app->user->isGuest): ?>
            <p>Увы, для продолжениря придется войти или зарегистрироваться! </p>
            <p>
                <a class="btn btn-lg btn-success" href="/login">Войти</a>
                <a class="btn btn-lg btn-info" href="/signup">Зарегистрироваться</a>
            </p>

        <? else: ?>
            <p> Добрый день, <?= Yii::$app->getUser()->identity->username ?> </p>


            <?php if (Yii::$app->getUser()->identity->role == User::ROLE_CLIENT): ?>
                <a class="btn btn-lg btn-success" href="/feedback">Оставить заявоку</a>
            <?php elseif (Yii::$app->getUser()->identity->role == User::ROLE_MANAGER): ?>
                <a class="btn btn-lg btn-success" href="/application">Посмотреть список заявок</a>
            <?php endif; ?>


        <?php endif; ?>
        <p>

        </p>
    </div>


</div>
