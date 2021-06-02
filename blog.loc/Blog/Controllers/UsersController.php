<?php
namespace Blog\Controllers;

use Blog\Exceptions\InvalidArgumentException;
use Blog\Exceptions\UnauthorizedException;
use Blog\Exceptions\ForbiddenException;
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
                $this->view->renderHTML('users/signUpSuccessful.php');
                return;
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

    public function admin()
    {
        if ($this->user === null) { throw new UnauthorizedException(); }
        elseif ($this->user->getRole() != 'admin') { throw new ForbiddenException(); }
        if(!empty($_POST))
        {
            try 
            {
                $this->user->admin($_POST); 
            }
            catch (InvalidArgumentException $e)
            {
                $users = User::findAll();
                $this->view->renderHTML('users/admin.php', ['error' => $e->getMessage(), 'users' => $users]);
                return;
            }
        }
        $users = User::findAll();
        $this->view->renderHTML('users/admin.php', ['users' => $users]);
    }
}
?>