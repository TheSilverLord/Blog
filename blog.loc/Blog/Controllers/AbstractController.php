<?php

namespace Blog\Controllers;

use Blog\View\View;
use Blog\Models\Users\User;
use Blog\Models\Users\UsersAuthService;

abstract class AbstractController
{
    protected $view;
    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../templates');
        $this->view->setVar('user', $this->user);
    }
}
?>