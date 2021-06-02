<?php

namespace Blog\Controllers;

use Blog\Models\Articles\Article;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::findAll();
        $this->view->renderHTML('main/main.php', ['articles' => $articles]);
    }
}

?>