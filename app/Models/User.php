<?php

namespace app\Models;

use app\core\base\Model;

class User extends Model
{
    public $table = "users";
    public $attributes = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];
    public $errors = [];
    public $rules = [
        'required' => [
            ['name'],
            ['email'],
            ['password'],
            ['password_confirmation'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ],
    ];

    public function checkMailAndName($data)
    {
        $result = Model::findOne($this->attributes['email'], "login ='" . $this->attributes['name'] . "' OR email");

        if ($result) {
            if ($data['name'] == $result[0]['login']) {
                $this->errors['unique'][] = 'this login already used';
            }
            if ($data['email'] == $result[0]['email']) {
                $this->errors['unique'][] = 'this email already used';
            }
            return false;
        }

        return true;
    }

    public function login()
    {
        $sult = "test";
        $login = !empty(trim($_POST['email'])) ? trim($_POST['email']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        $password = md5($password . $sult);
        if ($login && $password) {
            $result = Model::findOne($this->attributes['email'], 'email');

            if ($result) {
                if ($password === $result[0]['password']) {
                    foreach ($result as $k => $v) {
                        if ($k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
