<?php

namespace app\core\base;

use vendor\vlucas\valitron\src\Valitron\Validator;
use app\core\Db;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $pk = 'id';
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    public function load($data)
    {
        foreach ($data as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($data)
    {
        $sult = "test";
        $data['password'] = md5($data['password'] . $sult);
        $data['password_confirmation'] = md5($data['password_confirmation'] . $sult);
        $que = "INSERT INTO `users`(`login`, `email`, `password`,`confirm_password`) 
VALUES(:name,:email,:password,:confirmpassword)";
        $params = [
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':confirmpassword' => $data['password_confirmation']];
        Db::instance()->execute($que, $params);
    }

    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}"; //$this->table данне прописаны в модели они не приходят с контроллера если что сразу указываю!
        return $this->pdo->query($sql);
    }

    public function findOne($id, $field = '')
    {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = :id LIMIT 1"; //? - неименованный параметр  - $id, $field - это поле в модели оно не приходит из контроллера предупреждаю сразу
        $params = [ ':id' => $id];
        return $this->pdo->query($sql, $params);
    }

    public function findBySql($sql, $params = [])
    {
        return $this->pdo->query($sql, $params);
    }

    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    public function getRecordsInTable()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE `deleted_at` = 1";
        $res = $this->pdo->query($sql);
        $res = $res[0]['COUNT(*)'];
        return $res;
    }

    /**
     * Валидация данных
     */
    public function validate($data)
    {

        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) {
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }
}
