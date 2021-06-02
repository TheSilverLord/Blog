<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <div class="main">
        <h2>Список пользователей:</h2>
        <ul>
        <?php foreach ($users as $user): ?>
            <li><?= $user->getNickname() ?> | Роль: <?= $user->getRole() ?></li>
        <?php endforeach; ?>
        </ul>

        <form action="/users/admin" method="post">
            <label>Nickname <input type="text" name="nickname" value="<?= $_POST['nickname'] ?? '' ?>"></label>
            <br><br>
            <input type="submit" value="Выдать права администратора">
        </form>
    </div>
</div>
<?php include __DIR__ . '/../footer.php'; ?>