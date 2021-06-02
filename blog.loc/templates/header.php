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
        <td colspan="2" class="header">
            Web-технологии 2021 года
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if(!empty($user)):  
            echo 'Пользователь: ' . $user->getNickname(); ?> <span>| <a href="/users/logout">Выйти</a></span>
            <?php else: ?> <div><a href="/users/login">Войти на сайт</a> | <a href="/users/register">Регистрация</a></div>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>