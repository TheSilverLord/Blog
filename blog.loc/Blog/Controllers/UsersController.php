<?php
namespace Blog\Controllers;

use Blog\Exceptions\InvalidArgumentException;
use Blog\Models\Users\User;
use Blog\Models\Users\UsersAuthService;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if(!empty($_POST))
        {
            try
            {
                $user = User::signUp($_POST);
            }
            catch (InvalidArgumentException $e)
            {
                $this->view->renderHTML('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHTML('users/signUp.php');
    }

    public function login()
    {
        if(!empty($_POST))
        {
            try 
            { 
                $user = User::login($_POST); 
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            }
            catch (InvalidArgumentException $e)
            {
                $this->view->renderHTML('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHTML('users/login.php');
    }

    public function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
        header('Location: /');
    }
}
?>