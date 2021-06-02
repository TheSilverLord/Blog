<?php include __DIR__ . '/../header.php'; ?>
<div class="main">
<?php foreach ($articles as $article): ?>
    <h2><?= $article->getName() ?></h2>
    <h3>Автор: <?= $article->getAuthor()->getNickname() ?></h3>
    <div><?= $article->getText() ?></div>
    <p><a href=<?= "/articles/" . $article->getId() . "/edit"  ?>>Редактировать статью</a></p>
    <hr color=#ffffff>
<?php endforeach; ?>
</div>
<?php include __DIR__ . '/../footer.php'; ?>