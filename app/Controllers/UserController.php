<?php

namespace app\Controllers;

use app\Models\User;
use app\core\base\View;

class UserController extends BaseController
{
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $_POST['name'] = h($_POST['name']);
            $_POST['email'] = h($_POST['email']);
            $_POST['password'] = h($_POST['password']);
            $_POST['password_confirmation'] = h($_POST['password_confirmation']);
            $data = $_POST;
            $user->load($data);
            if ($user->validate($data) == false || $user->checkMailAndName($data) == false) {
                $user->getErrors();
                $_SESSION['form_data'] = $data;
                redirect();
            }
            if (!$user->save($data)) {
                $_SESSION['success'] = 'Вы успешно зарегистрировались';
                redirect('login');
            } else {
                $_SESSION['error'] = 'Ошибка попробуйте еще раз';
                redirect();
            }
        }
        View::setMeta('Registration');
    }

    public function loginAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $_POST['email'] = h($_POST['email']);
            $_POST['password'] = h($_POST['password']);
            $data = $_POST;
            $user->load($data);
            if ($user->login()) {
                $_SESSION['email'] = $data['email'];
                $_SESSION['success'] = 'Вы успешно авторизованы';
                redirect('/');
            } else {
                $_SESSION['error'] = 'Логин/пароль введены не верно';
            }
            redirect('login');
        }
        View::setMeta('Login');
    }

    public function logoutAction()
    {
        if (isset($_SESSION['email'])) {
            unset($_SESSION['email']);
        }
        redirect('login');
    }
}
