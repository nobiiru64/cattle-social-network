<!DOCTYPE html>
<html>
<head>
    <title><?= $appname . ' ' . $userString ?></title>

    <!-- <link rel="stylesheet" href="/style.css"> -->
     <script src="<?= asset('js/jquery-3.4.0.min.js') ?>"></script>
     <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
     <script src="<?= asset('js/script.js') ?>"></script>
    <script src="<?= asset('js/social.js') ?>"></script>
     <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark ">
    <a class="navbar-brand text-light" href="#"><?= $appname ?></a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <? if ($loggedin): ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link text-light" href="/">Главная</a></li>
                <li class="nav-item"><a class="nav-link text-light"  href="/users">Люди</a></li>
                <li class="nav-item"><a class="nav-link text-light"  href="/friends">Друзья</a></li>
                <li class="nav-item"><a class="nav-link text-light"  href="/messages/">Сообщения</a></li>
            </ul>
        <? else: ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link text-light" href="/">Главная</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="/signup">Зарегестрироваться</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="/login">Войти</a></li>
            </ul>
        <? endif; ?>

    <? if ($loggedin): ?>
        <div class="form-inline my-2 my-lg-0">
            <div class="pr-2">
                <img class="avatar-40" src="<?= getUserAvatar() .'?' . rand(0,100) ?>">
            </div>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Привет, <?= $user ?>!
                    </a>
                    <div class="dropdown-menu" style="left: -1vw;" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/profile">Профиль</a>
                        <a class="dropdown-item" href="/feed">Лента</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Выйти</a>
                    </div>
                </li>
            </ul>
        </div>

        <? endif; ?>
    </div>
</nav>
<?php if (!$loggedin && $signup): ?>
<div class="container text-center pt-5">
    <span class="info btn-outline-danger">You must be logged in to view this page.</span>
</div>
<? endif; ?>


