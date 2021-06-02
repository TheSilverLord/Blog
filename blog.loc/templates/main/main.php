<?php include __DIR__ . '/../header.php'; ?>
<?php foreach ($articles as $article): ?>
    <h2><?= $article->getName() ?></h2>
    <h3>Автор: <?= $article->getAuthor()->getNickname() ?></h3>
    <p><?= $article->getText() ?></p>
    <p><a href=<?= "/articles/" . $article->getId() . "/edit"  ?>>Редактировать статью</a></p>
    <hr>
<?php endforeach; ?>
<?php include __DIR__ . '/../footer.php'; ?>