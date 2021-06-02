<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Web-технологии 2021 года</title>
    <link rel="stylesheet" href="/../../styles.css">
</head>

<body>
<table class="layout">
    <tr>
        <td>
            <div class="container">
            <div class="header-bar">
                <h1 class="logo">Web-технологии 2021 года</h1>
                <ul class="slider-menu">
                    <li><a href="/">Главная страница</a></li>
                    <li><a href="/articles/add">Добавить статью</a></li>
                    <li><a href="/users/admin">Управление</a></li>
                    <?php if(!empty($user)): ?>
                        <li>|</li>
                        <li>Пользователь: <?= $user->getNickname(); ?></li>
                        <li><a href="/users/logout">Выйти</a></li>
                    <?php else: ?> 
                        <li><a href="/users/login">Войти на сайт</a></li> 
                        <li><a href="/users/register">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>