<?php

namespace Blog\Controllers;

use Blog\Models\Articles\Article;
use Blog\Exceptions\NotFoundException;
use Blog\Exceptions\UnauthorizedException;
use Blog\Exceptions\InvalidArgumentException;
use Blog\Exceptions\ForbiddenException;

class ArticlesController extends AbstractController
{
    public function edit(int $articleId): void // Добавить изменение пользователем (с использованием сеттеров)
    {
        $article = Article::getById($articleId);
        if($article === null)
        {
            throw new NotFoundException();
        }
        if ($this->user === null) { throw new UnauthorizedException(); }
        elseif ($this->user->getRole() != 'admin') { throw new ForbiddenException(); }

        if (!empty($_POST)) 
        {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }
    
            header('Location: /');
            exit();
        }
    
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        if ($this->user === null) { throw new UnauthorizedException(); }
        elseif ($this->user->getRole() != 'admin') { throw new ForbiddenException(); }
        if (!empty($_POST))
        {
            try
            {
                $article = Article::create($_POST, $this->user);
            }
            catch (InvalidArgumentException $e)
            {
                $this->view->renderHTML('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /');
            //header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHTML('articles/add.php');
    }
}

?>